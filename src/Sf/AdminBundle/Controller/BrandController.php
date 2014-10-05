<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sf\AdminBundle\Entity\Brand;
use Sf\AdminBundle\Form\BrandType;
use Sf\AdminBundle\Form\CreatorType;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Brand controller.
 *
 */
class BrandController extends Controller
{

    /**
     * Lists all Brand entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SfAdminBundle:Brand')->findBy(array('deleted' => false), array('name'=>'ASC'));

        return $this->render('SfAdminBundle:Brand:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new brand entity.
     *
     */
   public function createAction(Request $request)
    {
        $entity = new Brand();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedAt(new \DateTime())
                    ->setUpdatedAt(new \DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_brand'));
        }

        return $this->render('SfAdminBundle:Brand:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Brand entity.
     *
     * @param Brand $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Brand $entity)
    {
        $form = $this->createForm(new BrandType(), $entity, array(
            'action' => $this->generateUrl('admin_brand_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
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
    * Creates a form to edit a Brand entity.
    *
    * @param Brand $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
     private function createEditForm(Brand $entity)
    {
        $form = $this->createForm(new BrandType(), $entity, array(
            'action' => $this->generateUrl('admin_brand_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
 
    /**
     * Edits an existing Brand entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SfAdminBundle:Brand')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Brand entity.');
        }

        $originalPictures = new ArrayCollection();
        foreach ($entity->getBrandCreators() as $picture) {
            $originalPictures->add($picture);
        }
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
         /* if ($entity->getIllustrativePicture() != null 
                  || $entity->getLogo() != null 
                  || $entity->getIconLegend() != null){
            $entity->removeUpload();
            
          }
           if ($entity->getIllustrativePicture() != null){
            $imgString = $entity->getIllustrativePicture()->getClientOriginalName();
            $entity->setIllustrativePictureUrl($imgString);
           }
           
           if ($entity->getLogo() != null){
            $imgString = $entity->getLogo()->getClientOriginalName();
            $entity->setLogoUrl($imgString);
           }
           
            if ($entity->getIconLegend() != null){
            $imgString = $entity->getIconLegend()->getClientOriginalName();
            $entity->setIconLegendUrl($imgString);
           }*/
          
            $creators = $entity->getBrandCreators();
            $creators[0]->preUpload();
              // $creators[0]      ->upload();
            
          foreach ($originalPictures as $picture) {
              
            if ($entity->getBrandCreators()->contains($picture) == false) {
                $entity->getBrandCreators()->removeElement($picture);
                $em->remove($picture);
                $em->persist($entity);
            }
          }
          
          $em->persist($entity);
          $em->flush();
          
          

            return $this->redirect($this->generateUrl('admin_brand_edit', array('id' => $id)));
        }

        return $this->render('SfAdminBundle:Brand:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Brand entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SfAdminBundle:Brand')->find($id);
            $entity->setDeleted(true);
            $entity->setDeletedAt(new \DateTime);
           /*foreach ($entity->getRubricPictures() as $picture) {

                  $entity->getRubricPictures()->removeElement($picture);
              $em->remove($picture);
              $em->persist($entity);
            }*/

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Brand entity.');
            }

           $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_brand'));
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
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }



}
