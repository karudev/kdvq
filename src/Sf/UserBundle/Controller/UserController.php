<?php

namespace Sf\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sf\UserBundle\Form\Type\RegistrationType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * User controller.
 *
 */
class UserController extends Controller {

    /**
     * Lists all User entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SfUserBundle:User')->findAll();

        return $this->render('SfUserBundle:User:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * 
     * @Template()
     * */
    public function registrationAction(Request $request) {

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();


        $form = $this->createForm(new RegistrationType, $user);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                
                $user->setRoles(array('ROLE_CUSTOMER'));
               // $user->setUsername($data->getEmail());
                $this->container->get('sf_user.user_manager')->updateUser($user);

                return new JsonResponse(array(
                    'success' => true,
                    'redirect' => $this->generateUrl('fos_user_security_login', array(), true)
                ));
            } else {
                return new JsonResponse(array(
                    'form' => $this->renderView('SfUserBundle:User:registration.html.twig', array('form' => $form->createView())
                )));
            }
        }

        return array('form' => $form->createView());
    }

    public function logoutAction() {
        //do whatever you want here 
        //clear the token, cancel session and redirect
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return $this->redirect($this->generateUrl('fos_user_security_login'));
    }

}
