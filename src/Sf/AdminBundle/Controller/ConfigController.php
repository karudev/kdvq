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

        $google = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'google'));
        $facebook = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'facebook'));
        $twitter = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'twitter'));
        $factory_email = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'factory_email'));
        $home_title = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'home_title'));
        $home_text = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'home_text'));
        $products_intro = $em->getRepository('SfAdminBundle:Config')->findOneBy(array('name' => 'products_intro'));
        if (!$google) {
            $google = new Config();
            $google->setName('google');
            $google->setValue('http://google.com');
            $em->persist($google);
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
        
        if (!$factory_email) {
            $factory_email = new Config();
            $factory_email->setName('factory_email');
            $factory_email->setValue('renault@karudev.fr');
            $em->persist($factory_email);
            
        }
        if (!$home_title) {
            $home_title = new Config();
            $home_title->setName('home_title');
            $home_title->setValue('Le Lorem Ipsum est simplement du faux texte employé');
            $em->persist($home_title);
            
        }
        
        if (!$home_text) {
            $home_text = new Config();
            $home_text->setName('home_text');
            $home_text->setValue('Il n\'a pas fait que survivre cinq siècles, mais s\'est aussi adapté à la bureautique informatique, sans que son contenu n\'en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.');
            $em->persist($home_text);
            
        }
        
        if (!$products_intro) {
            $products_intro = new Config();
            $products_intro->setName('products_intro');
            $products_intro->setValue('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed Ut anim ad minim veniam, quis nostrud exercitation simpson');
            $em->persist($products_intro);
            
        }
        
        if ($request->getMethod() == 'POST') {
            $googleValue = $request->get('google', 0);
            $google->setValue($googleValue);
            $em->persist($google);
            
            $twitterValue = $request->get('twitter');
            $twitter->setValue($twitterValue);
            $em->persist($twitter);
            
            $facebookValue = $request->get('facebook');
            $facebook->setValue($facebookValue);
            $em->persist($facebook);
            
            $factory_email_value = $request->get('factory_email');
            $factory_email->setValue($factory_email_value);
            $em->persist($factory_email);
            
            $home_title_value = $request->get('home_title');
            $home_title->setValue($home_title_value);
            $em->persist($home_title);
            
               
            $home_text_value = $request->get('home_text');
            $home_text->setValue($home_text_value);
            $em->persist($home_text);
            
            $products_intro_value = $request->get('products_intro');
            $products_intro->setValue($products_intro_value);
            $em->persist($products_intro);
           
        }
        
        $em->flush();
        
        return array(
            'google' => $google,
            'facebook' => $facebook,
            'twitter' => $twitter,
            'factory_email' => $factory_email,
            'home_title' => $home_title,
            'home_text' => $home_text,
            'products_intro' => $products_intro);

    }

}
