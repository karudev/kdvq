<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class MailType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('subject','text')
                ->add('text','textarea',array('required' => false))
                
        ;
    }
    
   


    /**
     * @return string
     */
    public function getName() {
        return 'mail';
    }

}
