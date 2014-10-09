<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class BrandType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('picture','file',array('required' => false))
            ->add('picture2','file',array('required' => false))
            ->add('textPicture','file',array('required' => false))
            ->add('textPicture2','file',array('required' => false))
            ->add('centerPicture','file',array('required' => false))
           
          
            ->add('title','text', array('required' => false))
            ->add('subtitle','text', array('required' => false))
            ->add('title2','text', array('required' => false))
            ->add('subtitle2','text', array('required' => false))
            ->add('text','textarea', array('required' => false))
            ->add('text2','textarea', array('required' => false))
          
            ->add('active','checkbox', array('required' => false));

          
          
           
        
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'brand';
    }
}
