<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title')
                ->add('address')
                ->add('additionalAddress', 'text', array('required' => false))
                ->add('zipCode')
                ->add('city')
                ->add('country')
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
