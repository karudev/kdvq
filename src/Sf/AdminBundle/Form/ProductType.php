<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sf\AdminBundle\Entity\CategoryRepository;
use Sf\AdminBundle\Form\ProductPictureType;

class ProductType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', 'entity', array(
                    'class' => 'SfAdminBundle:Category',
                    'property' => 'label',
                    'query_builder' => function(CategoryRepository $er) {
                return $er->getQueryBuilder();
            },
                ))
                ->add('name')
                //->add('subTitle','text',array('required' => false))
                ->add('metaKeywords','text',array('required' => false))
                ->add('metaDescription','textarea',array('required' => false))
                ->add('description','textarea',array('required' => false))
                ->add('details','textarea',array('required' => false))
                ->add('composition','textarea',array('required' => false))
                ->add('boardMaintenance','textarea',array('required' => false))
                
                ->add('priceHt','text',array('attr' => array('class' => 'col-xs-3' )))
                ->add('tva','text',array('attr' => array('class' => 'col-xs-3' )))
                ->add('youtubeId','text',array('required' => false))
                ->add('mainPicture', 'file', array('required' => false))
                ->add('hdPicture', 'file', array('required' => false))
                ->add('productPictures', 'collection', array(
                'label' => 'Photos supplémentaires du produit',
                      'type' => new ProductPictureType(),
                    'allow_add' => true,
                      'allow_delete' =>true,
                    'by_reference' =>false,
                      ))
                ->add('active','checkbox', array('required' => false))
                ->add('inHome','checkbox', array('required' => false))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Sf\AdminBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'product';
    }

}
