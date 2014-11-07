<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sf\AdminBundle\Form\CriterionType;
use Sf\AdminBundle\Entity\Size;
use Sf\AdminBundle\Entity\Color;
use Sf\AdminBundle\Entity\Material;

class CriterionController extends Controller {

    /**
     * @Template()
     *
     *
     */
    public function indexAction() {

        $em = $this->get('doctrine')->getManager();
        $sizes = $em->getRepository('SfAdminBundle:Size')->findBy(array(), array('name' => 'asc'));
        $colors = $em->getRepository('SfAdminBundle:Color')->findBy(array(), array('name' => 'asc'));
        $materials = $em->getRepository('SfAdminBundle:Material')->findBy(array(), array('name' => 'asc'));




        return array('sizes' => $sizes, 'colors' => $colors, 'materials' => $materials);
    }

    /**
     * @Template()
     *
     *
     */
    public function updateAction(Request $request, $type = null, $id = null) {
        $em = $this->get('doctrine')->getManager();
        $criterion = $request->get('criterion');

        $entity = 'Size';

        $type = isset($criterion['type']) && $criterion['type'] != null ? $criterion['type'] : $type;
        $id = isset($criterion['id']) && $criterion['id'] != null ? $criterion['id'] : $id;


       
        
        if ($type == 'C') {
            $entity = 'Color';
        } elseif ($type == 'M') {
            $entity = 'Material';
        }
           

        if ($id > 0) {
            $c = $em->getRepository('SfAdminBundle:' . $entity)->find($id);
        } else {
            if ($entity == 'Size')
                $c = new Size;
            elseif ($entity == 'Color')
                $c = new Color;
            elseif ($entity == 'Material')
                $c = new Material;
            
          
        }


        if (isset($criterion['active']) && $criterion['active'] != null)
            $active = (bool) $criterion['active'];
        elseif ($request->getMethod() == 'POST')
            $active = false;
        else
            $active = $c->getActive();

        $name = isset($criterion['name']) && $criterion['name'] != null ? $criterion['name'] : $c->getName();

        $form = $this->createForm(new CriterionType, $c, array('data' => array(
                'active' => $active,
                'name' => $name,
                'type' => $type)));
        if ($request->getMethod() == 'POST') {


            $c->setName($name);


            $c->setActive($active);



            $em->persist($c);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_criterion'));
        }

        return array('form' => $form->createView());
    }

}
