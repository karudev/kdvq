<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FooterController extends Controller {

    /**
     * 
     * @Template()
     * 
     */
    public function showAction() {

        $em = $this->getDoctrine()->getManager();

        $facebook = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'facebook'));
        $twitter = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'twitter'));
        $google = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'google'));
        $categories = $em->getRepository('SfAdminBundle:Category')->findBy(array('active' => true, 'category' => null));
        return $this->render('SfFrontBundle::footer.html.twig', array(
                    'facebook' => $facebook,
                    'twitter' => $twitter,
                    'google' => $google,
            'categories' => $categories
        ));
    }

}

?>
