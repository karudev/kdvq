<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sf\AdminBundle\Form\AddressType;


class ShopType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tradeName','text',array('required' => true))
                ->add('socialName','text',array('required' => true))
                ->add('siret','text', array('required' => false))
                ->add('email','email', array('required' => true))
                ->add('country','text', array('required' => false))
                ->add('phone', 'text', array('required' => false))
                ->add('background','textarea', array('required' => false))
                ->add('tva')
                ->add('autoEntrepreneur','checkbox',array('required' => false))
                ->add('addresses', 'collection', array(
                
                      'type' => new AddressType(),
                    'allow_add' => true,
                    'by_reference' =>false,
                      ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            
            'validation_groups' => array('shop'),
            'cascade_validation' => true

        ));
    }


    /**
     * @return string
     */
    public function getName() {
        return 'account';
    }

}
