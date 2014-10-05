<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sf\AdminBundle\Entity\Brand;
use Sf\AdminBundle\Form\GroupType;
use Sf\AdminBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Brand controller.
 *
 */
class GroupController extends Controller
{

   
    
    /**
     * @Template()
     * Lists all Group entities.
     *
     */
    public function indexAction(Brand $brand)
    {
       // \Doctrine\Common\Util\Debug::dump($brand); die();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SfAdminBundle:Group')->findBy(array('brand' => $brand->getId()), array( 'name'=>'ASC'));

        return  array('entities' => $entities,'brand' => $brand);
    }
    /**
     * @Template()
     * Manage a group entity.
     *
     */
   public function updateAction(Request $request,Brand $brand, $id = null)
    {
        $em = $this->getDoctrine()->getManager();
        if($id !=null){
           $entity = $em->getRepository('SfAdminBundle:Group')->find($id);
           $title =  $this->get('translator')->trans('%brand% : Modification du groupe', array('%brand%' => $brand->getName() ));
        }else{
           $entity = new Group(); 
           $title = $this->get('translator')->trans('%brand% : Création d\'un groupe', array('%brand%' => $brand->getName() ));
        }
         $entity->setBrand($brand);
      
        $form = $this->createForm(new GroupType(), $entity);
        $form->add('submit', 'submit', array(
            'attr'=> array('class' => 'btn btn-success'),
            'label' => 'Sauvegarder')
                );
       
        
        $form->handleRequest($request);
        

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedAt(new \DateTime())
                    ->setUpdatedAt(new \DateTime());
          
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_group',array('brand'=> $brand->getId())));
        }

        return array(
            'entity' => $entity,
            'title' => $title,
            'form'   => $form->createView(),
        );
    }

    
    
    /**
     * Displays a form to create a new Rubric entity.
     *
     */
    public function newAction()
    {
        $entity = new Brand();
        $form   = $this->createCreateForm($entity);

        return $this->render('SfAdminBundle:Brand:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Brand entity.
     *
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SfAdminBundle:Brand')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }


        return $this->render('SfAdminBundle:Brand:show.html.twig', array(
            'entity'      => $entity
        ));
    }

    /**
     * Displays a form to edit an existing Rubric entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SfAdminBundle:Brand')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }

        $editForm = $this->createEditForm($entity);
       // $editCreatorForm = $this->createForm(new CreatorType(), $entity->getCreator());

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SfAdminBundle:Brand:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
           // 'edit_creator_form' => $editCreatorForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    
 
  
    /**
     * Delete a Group entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SfAdminBundle:Group')->find($id);
            $entity->setDeleted(true);
            $entity->setDeletedAt(new \DateTime);
           /*foreach ($entity->getRubricPictures() as $picture) {

                  $entity->getRubricPictures()->removeElement($picture);
              $em->remove($picture);
              $em->persist($entity);
            }*/

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Group entity.');
            }

            $brand =  $entity->getBrand();
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_group',array('brand' => $brand)));
    }
    
   


    /**
     * Creates a form to delete a Brand entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_brand_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Suprimer'))
            ->getForm()
        ;
    }



}
