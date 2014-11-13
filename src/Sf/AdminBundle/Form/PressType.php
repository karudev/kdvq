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
            ->add('mainPicture','file',array('label' => 'Photo principale','required' => false))
            ->add('secondPicture','file',array('label' => 'Photo secondaire','required' => false))
           // ->add('title')
            ->add('parutionTitle','text', array('label' => 'Titre de la parution','required' => false))
            ->add('parutionSubTitle','text', array('label' => 'Sous-titre de la parution','required' => false))
            ->add('text','textarea', array('label' => 'Texte','required' => false))
            ->add('active','checkbox', array('label' => 'Actif ?','required' => false));

          
          
           
        
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'press';
    }
}
