<?php

namespace Sf\AdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sf\AdminBundle\Entity\Config;

/**
 * Config controller.
 *
 */
class ConfigController extends Controller {

    /**
     * @Template()
     * 
     *
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $btoc = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'btoc'));
        $facebook = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'facebook'));
        $twitter = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'twitter'));
        if (!$btoc) {
            $btoc = new Config();
            $btoc->setName('btoc');
            $btoc->setValue(0);
            $em->persist($btoc);
            $em->flush();
        }
        if (!$facebook) {
            $facebook = new Config();
            $facebook->setName('facebook');
            $facebook->setValue('http://facebook.com');
            $em->persist($facebook);
            
        }
        if (!$twitter) {
            $twitter = new Config();
            $twitter->setName('twitter');
            $twitter->setValue('http://twitter.com');
            $em->persist($twitter);
            
        }
        
        if ($request->getMethod() == 'POST') {
            $btocValue = $request->get('btoc', 0);
            $btoc->setValue($btocValue);
            $em->persist($btoc);
            
            $twitterValue = $request->get('twitter');
            $twitter->setValue($twitterValue);
            $em->persist($twitter);
            
            $facebookValue = $request->get('facebook');
            $facebook->setValue($facebookValue);
            $em->persist($facebook);
           
        }
        
        $em->flush();

        return array(
            'btoc' => $btoc,
            'facebook' => $facebook,
            'twitter' => $twitter);
    }

}
