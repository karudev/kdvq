<?php

namespace Sf\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class NavController extends Controller {

    /**
     * @Template()
     * */
    public function showAction(Request $request) {

        $em = $this->get('doctrine')->getManager();
        $categories = $em->getRepository('SfAdminBundle:Category')->findBy(array('active' => true, 'category' => null),array('position' => 'asc'));
        return array('categories' => $categories, 
            '_route' => $request->attributes->get('_route'),
            'mobile' =>$request->attributes->get('mobile')
           
        );
    }

}

?>
