<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sf\AdminBundle\Form\AccountType;
use Sf\AdminBundle\Form\Address2Type;
use Sf\UserBundle\Entity\Address;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sf\AdminBundle\Form\ShopType;
use Sf\UserBundle\Entity\User;
use Symfony\Component\Form\FormError;

class AccountController extends Controller {

    /**
     * @Template()
     * 
     *
     */
    public function listAction() {

        return array();
    }

    /**
     * @Template()
     * 
     *
     */
    public function accountsListAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $accounts = $em->getRepository('SfUserBundle:User')->getAll();
        return array('accounts' => $accounts);
    }

    /**
     * @Template()
     * 
     *
     */
    public function updateAction(Request $request, User $user = null) {

        $em = $this->getDoctrine()->getManager();
        $new = false;
        if ($user == null) {
            $user = new User;
            $new = true;
        }else{
            if(!$em->getRepository('SfUserBundle:Address')->findOneBy(array('type'=>'shipping','account' => $user->getId()))){
            $a = new Address;
            $a->setAccount($user)
                    ->setType('shipping');
            $user->addAddress($a);
            }
            if(!$em->getRepository('SfUserBundle:Address')->findOneBy(array('type'=>'billing','account' => $user->getId()))){
            
            $a2 = new Address;
            $a2->setAccount($user)
                    ->setType('billing');
            $user->addAddress($a2);
            }
           
        
        }
        
        

        $form = $this->createForm(new ShopType, $user, array('action' =>
            $this->generateUrl('admin_account_update', array('user' => $user->getId()))));
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);


            if ($form->isValid()) {
                if($new){
                $user->setRoles(array('ROLE_SHOP'));
                }
                $user->setPlainPassword(substr(md5(time()), 0, 8));
                $user->setUsername($user->getEmail());



                if ($user->getId() != null) {
                    # Vérification of email
                    if ($em->getRepository('SfUserBundle:User')->checkEmail($user)) {
                        $error = new FormError('Cette email existe déja');
                        $form->get('email')->addError($error);
                        return new JsonResponse(array(
                            'success' => false,
                            'form' => $this->renderView('SfAdminBundle:Account:update.html.twig', array('form' => $form->createView())
                        )));
                    } else {
                        $em->persist($user);
                        $em->flush();
                        return new JsonResponse(array(
                            'success' => true,
                            'html' => $this->forward('SfAdminBundle:Account:accountsList')->getContent()
                        ));
                    }
                }
                $retour = $this->container->get('sf_user.user_manager')->updateUser($user);


                if ($retour['success']) {
                    return new JsonResponse(array(
                        'success' => true,
                        'html' => $this->forward('SfAdminBundle:Account:accountsList')->getContent()
                    ));
                } else {
                    $error = new FormError($retour['message']);
                    $form->get('email')->addError($error);
                    return new JsonResponse(array(
                        'success' => false,
                        'form' => $this->renderView('SfAdminBundle:Account:update.html.twig', array('form' => $form->createView())
                    )));
                }
            } else {
                \Doctrine\Common\Util\Debug::dump($form->getErrorsAsString()); die();
                return new JsonResponse(array(
                    'success' => false,
                    'form' => $this->renderView('SfAdminBundle:Account:update.html.twig', array('form' => $form->createView())
                )));
            }
        }
        return array('form' => $form->createView());
    }

    /**
     * @Template()
     * 
     *
     */
    public function controlAction(Request $request) {

        if ($this->getUser()->hasRole('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('orders'));
        } elseif ($this->getUser()->hasRole('ROLE_CUSTOMER') || $this->getUser()->hasRole('ROLE_SHOP')) {
            $session = $request->getSession();
            if($session->get('cartRedirect')){
                return $this->redirect($this->generateUrl('front_shopping_cart'));
                $session->set('cartRedirect',false);
            }else{
                return $this->redirect($this->generateUrl('account'));
            }
            
        }
    }

    /**
     * @Template()
     *
     *
     */
    public function indexAction(Request $request, $message = null) {
        $redirect = null;



        if ($message == 1) {
            $message = $this->container->get('translator')->trans('Veuillez renseigner votre adresse de livraison pour valider vos achats', array(), 'SfFrontBundle');
            $this->container->get('session')->getFlashBag()->add('info', $message);
            $redirect = 'front_shopping_cart';
        }
        $em = $this->getDoctrine()->getManager();
        
       $user = $this->getUser();
        if ($user->hasRole('ROLE_SHOP')) {
            return $this->render('SfAdminBundle:Account:shopProfil.html.twig');
        }
        
       
       
        //\Doctrine\Common\Util\Debug::dump(  $user->getPassword()); die();
        // $user->setLastname($user->getPassword());
        $form = $this->createForm(new AccountType, $user);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
          //  if ($form->isValid()) {
                $em->persist($user);
                $em->flush();
               

                $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
                        $user, null, 'main', $user->getRoles()
                );

                $this->container->get('security.context')->setToken($token);
                
                $message = $this->container->get('translator')->trans('Vos informations personnelles ont bien été sauvegardées', array(), 'SfFrontBundle');
                $this->container->get('session')->getFlashBag()->add('success', $message);
            
        }



        return array('form' => $form->createView(), 'redirect' => $redirect);
    }

    /**
     * @Template()
     *
     *
     */
    public function addressAction(Request $request, $type = 'shipping', $redirect = null) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $address = $em->getRepository('SfUserBundle:Address')->findOneBy(array('account' => $user->getId(), 'type' => $type));
        $boolAddress = (bool) $address;

        if (!$address) {
            $address = new Address;
            $address->setAccount($user);
        }
        $form = $this->createForm(new AddressType, $address, array(
            'action' => $this->generateUrl('address', array('type' => $type, 'redirect' => $redirect))));
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $address->setType($type);
                $em->persist($address);
                $em->flush();
                $message = $this->container->get('translator')->trans('Votre adresse a été sauvegardée', array(), 'SfFrontBundle');
                $this->container->get('session')->getFlashBag()->add('success', $message);

                if ($redirect == null)
                    $redirect = 'account';

                return new JsonResponse(array(
                    'success' => true,
                    'redirect' => $this->generateUrl($redirect, array(), true)
                ));
            } else {
                return new JsonResponse(array(
                    'type' => $type,
                    'form' => $this->renderView('SfAdminBundle:Account:address.html.twig', array('form' => $form->createView())
                )));
            }
        }



        return array('boolAddress' => $boolAddress, 'type' => $type, 'form' => $form->createView());
    }

}
