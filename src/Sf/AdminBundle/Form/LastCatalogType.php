<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class LastCatalogType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
          //  ->add('picture','file',array('required' => false))
            ->add('file','file',array('required' => false))
          //  ->add('title')
         //   ->add('text','textarea', array('required' => false))
           ;

          
          
           
        
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'last_catalog';
    }
}
