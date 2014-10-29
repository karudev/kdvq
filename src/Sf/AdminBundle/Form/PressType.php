<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PressType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           /* ->add('brand','entity',array(
                'class' => 'SfAdminBundle:Brand',
                'property' => 'name'))*/
            ->add('mainPicture','file',array('required' => false))
            ->add('secondPicture','file',array('required' => false))
           // ->add('title')
            ->add('parutionTitle','text', array('required' => false))
            ->add('parutionSubTitle','text', array('required' => false))
            ->add('text','textarea', array('required' => false))
            ->add('active','checkbox', array('required' => false));

          
          
           
        
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'press';
    }
}
