<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PubType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array('required' => false))
                ->add('link', 'url', array('required' => false))
                ->add('picture', 'file', array('required' => false))
                ->add('active', 'checkbox', array('required' => false))
                ->add('position', 'text', array('required' => false))

        ;
    }

    

    /**
     * @return string
     */
    public function getName() {
        return 'pub';
    }

}
