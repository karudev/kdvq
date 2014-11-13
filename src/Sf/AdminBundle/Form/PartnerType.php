<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PartnerType extends AbstractType
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
            ->add('picture','file',array('required' => false))
            ->add('pictureHd','file',array('required' => false))
           
           // ->add('title')
            ->add('title','text', array('required' => false))
            ->add('type','choice', array('choices' => array('club' => 'Club','partner' => 'Partenaire')))
           // ->add('text','textarea', array('required' => false))
            ->add('active','checkbox', array('required' => false));

          
          
           
        
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'partner';
    }
}
