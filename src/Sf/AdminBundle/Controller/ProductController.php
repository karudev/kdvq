<?php

namespace Sf\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sf\AdminBundle\Form\ProductType;
use Sf\AdminBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Product controller.
 *
 */
class ProductController extends Controller {

    /**
     * @Template()
     * Lists all Product entities.
     *
     */
    public function indexAction($groupId = null) {
        $em = $this->getDoctrine()->getManager();
        $filter = array();
        if ($groupId != null) {
            $group = $em->getRepository('SfAdminBundle:Group')->find($groupId);
            $filter = array('group' => $group);
        }
        // \Doctrine\Common\Util\Debug::dump($brand); die();


        $entities = $em->getRepository('SfAdminBundle:Product')->findBy($filter, array('name' => 'ASC'));

        return array('entities' => $entities);
    }

    /**
     * @Template()
     * Manage a product entity.
     *
     */
    public function updateAction(Request $request, $id = null) {

        $em = $this->getDoctrine()->getManager();
        if ($id != null && $id != 0) {
            $entity = $em->getRepository('SfAdminBundle:Product')->find($id);

            $title = 'Modification du produit';
        } else {
            $entity = new Product();
            $entity->setCreatedAt(new \DateTime());
            $title = 'Création du produit';
        }

        $form = $this->createForm(new ProductType(), $entity);
        $form->add('submit', 'submit', array(
            'attr' => array('class' => 'submit'),
            'label' => 'Sauvegarder')
        );


        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setUpdatedAt(new \DateTime());
            $entity->setPriceTtc($entity->getPriceHt() + $entity->getTva());
            $entity->preUpload();
            foreach ($entity->getProductPictures() as $value) {
                $value->preUpload();
                $em->persist($value);
            }
            $em->persist($entity);
            $em->flush();
            $entity->upload();
            foreach ($entity->getProductPictures() as $value) {
                $value->upload();
            }

            return $this->redirect($this->generateUrl('admin_product'));
        }

        return array(
            'entity' => $entity,
            'title' => $title,
            'form' => $form->createView(),
        );
    }

    /**
     * Deletes a Brand entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SfAdminBundle:Brand')->find($id);
            $entity->removeUpload();
            /* foreach ($entity->getRubricPictures() as $picture) {

              $entity->getRubricPictures()->removeElement($picture);
              $em->remove($picture);
              $em->persist($entity);
              } */

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Brand entity.');
            }

            $em->remove($entity);
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
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('admin_brand_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Suprimer'))
                        ->getForm()
        ;
    }

}
