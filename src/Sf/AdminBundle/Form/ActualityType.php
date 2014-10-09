<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActualityType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder
                ->add('title')
            
                ->add('picture', 'file', array('required' => false))
                 ->add('pictureHome', 'file', array('required' => false))
               ->add('link', 'text', array('required' => false))
                ->add('text', 'textarea', array('required' => false))
              
                ->add('active', 'checkbox', array('required' => false))
                  ->add('inHome', 'checkbox', array('required' => false))
              
                ->add('date', 'date', array(
                    'attr' => array('placeholder' => 'jj/mm/aaaa'),
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
        ));



        
    }

    /**
     * @return string
     */
    public function getName() {
        return 'actuality';
    }

}
