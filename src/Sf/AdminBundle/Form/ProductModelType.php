<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ProductModelType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                
               
                ->add('size', 'entity', array(
                   
                    'property' => 'name',
                    'class' => 'SfAdminBundle:Size',
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
            },
                    'required' => false))
                ->add('color', 'entity', array(
                    'property' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
            },'class' => 'SfAdminBundle:Color', 'required' => false))
                ->add('material', 'entity', array(
                    'property' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
            },'class' => 'SfAdminBundle:Material', 'required' => false))
                ->add('product', 'entity', array(
                    
                    'property' => 'name',
                    'class' => 'SfAdminBundle:Product',
                    'required' => false))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sf\AdminBundle\Entity\ProductModel'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'sf_adminbundle_product_model';
    }

}
