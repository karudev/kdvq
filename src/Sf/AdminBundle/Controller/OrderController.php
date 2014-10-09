<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sf\AdminBundle\Form\OrderType;
use Sf\AdminBundle\Entity\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sf\AdminBundle\Entity\OrderStatus;

class OrderController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction() {

        // var_dump( $this->getUser() ); die();
        if ($this->getUser() == null) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }



        return array(
        );
    }

    /**
     * @Template()
     *
     *
     */
    public function ordersAction($number = 0) {

        $em = $this->getDoctrine()->getManager();

        if ($this->getUser()->hasRole('ROLE_ADMIN')) {
            $user = null;
        } else {
            $user = $this->getUser();
        }

        $coliposteUrl = $this->container->getParameter('colisposte_url');


        $ordersCompleted = $em->getRepository('SfAdminBundle:Order')->get($user, 'Completed');
        $ordersInProgress = $em->getRepository('SfAdminBundle:Order')->get($user, 'In-Progress');

        return $this->render('SfAdminBundle:Order:orders.html.twig', array(
                    'coliposteUrl' => $coliposteUrl,
                    'ordersInProgress' => $ordersInProgress,
                    'ordersCompleted' => $ordersCompleted,
                    'number' => $number));
    }

    public function updateAction(Request $request, Order $order, $number = 0) {

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new OrderType(), $order, array(
            'action' => $this->generateUrl('order_update', array('number' => $number, 'order' => $order->getId()))
        ));

        $statusForm = array();
        foreach ($order->getOrderStatus() as $sta) {
            $statusForm[$sta->getStatus()] = true;
        }

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {


                $em->persist($order);

                $this->get('order')->initStatus($order);
                $status = $request->get('status', array());
                foreach ($status as $key => $s) {

                    $os = new OrderStatus();
                    $os->setStatus($s)
                            ->setOrder($order);
                    $em->persist($os);

                    $order->addOrderStatus($os);

                    if ($s == "envoyee") {
                        # Send mail after have to change ther order informations
                        $this->get('sf_user.mail_helper')->changeOrder($order);
                        $order->setStatus('Completed');
                        $em->persist($order);
                        $em->flush();

                        # generate the invoice
                        $this->get('invoice')->create($order);
                    }

                    $em->persist($order);
                }

                $em->flush();





                return new JsonResponse(array(
                    'html' => $this->forward('SfAdminBundle:Order:orders', array('number' => $number))->getContent(),
                    'success' => true
                        )
                );
            }
        }

        return new JsonResponse(array(
            'form' => $this->renderView('SfAdminBundle:Order:update.html.twig', array(
                'form' => $form->createView(), 'statusForm' => $statusForm)
            )
        ));
    }

    public function validateAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $context = $this->get('security.context');
        if ($context->isGranted('ROLE_SHOP') || $context->isGranted('ROLE_ADMIN')) {

            if ($context->isGranted('ROLE_SHOP')) {
                $user = $this->getUser();
            } else {
                $user = $em->getRepository('SfUserBundle:User')->find($request->get('number'));
            }

            $token = md5(time() . $user->getId());

            $data = $this->get('shoppingcart')->getTotalAmount($user);

            $this->get('shoppingcart')->save($user, null, $token);

            # Update the order
            $order = $this->get('order')->update($user, $data['ht'], $data['ttc'], $data['tva'], $data['shippingCosts'], null, $token);
            # Send email
            if ($order) {
                $this->get('sf_user.mail_helper')->confirmOrder($order);
            }



            return $this->redirect($this->generateUrl('orders'));
        } else {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }
    }

    public function loadShoppingCartAction(Request $request, Order $order) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('SfAdminBundle:ShoppingCart')->findBy(array('order' => $order->getId()));

        // $data = $request->getSession()->get('products');
        // \Doctrine\Common\Util\Debug::dump($entity); die();






        if ($entity) {

            $this->get('shoppingcart')->reset();
            $products = array();

            foreach ($entity as $key => $value) {
                if ($value->getProduct()->getSlug() != null) {



                    $params = array(
                        'quantity' => $value->getQuantity(),
                        'color' => $value->getColor(),
                        'material' => $value->getMaterial(),
                        'size' => $value->getSize()
                            );

                    $stock = $em->getRepository('SfAdminBundle:ProductModel')->getStockByCriterion($value->getProduct(), $params);

                    if ($stock < $value->getQuantity()) {
                        $products[$key]['quantity'] = $stock;
                    } else {
                        $products[$key]['quantity'] = $value->getQuantity();
                    }

                    $products[$key]['color'] = $value->getColor();
                    $products[$key]['material'] = $value->getMaterial();
                    $products[$key]['size'] = $value->getSize();
                    $products[$key]['product'] = $value->getProduct();
                }
            }

            $request->getSession()->set('products', $products);
        }
        $message = $this->get('translator')->trans('Votre panier a été mise à jour', array(), 'SfFrontBundle');

        return new JsonResponse(array('success' => true, 'message' => $message));
    }

}
