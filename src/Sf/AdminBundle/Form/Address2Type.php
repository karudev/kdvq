<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Address2Type extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title','text', array('required' => false))
                ->add('address','text', array('required' => false))
                ->add('additionalAddress', 'text', array('required' => false))
                ->add('zipCode','text', array('required' => false))
                ->add('city','text', array('required' => false))
                ->add('country','text', array('required' => false))
                ->add('type','hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            
            'data_class' => 'Sf\UserBundle\Entity\Address'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'address';
    }

}
