<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AboutUsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('picture','file',array('required' => false))
            ->add('title')
            ->add('subTitle','text', array('required' => false))
            ->add('subTitle2','text', array('required' => false))
            ->add('text','textarea', array('required' => false))
            ->add('active','checkbox', array('required' => false));

          
          
           
        
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'aboutus';
    }
}
