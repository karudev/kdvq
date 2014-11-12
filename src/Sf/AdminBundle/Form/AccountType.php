<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class AccountType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility','choice',array(
                'label' => 'Civilité',
                'choices' => array('M' => 'Mr', 'MME' => 'Mme', 'MLLE' => 'Mlle'),
                'expanded' => true,
                'required' => false,
                ))
            ->add('firstname','text',array('label' => 'Prénom'))
            ->add('lastname','text',array('label' => 'Nom'))
            ->add('phone','text',array('label' => 'Téléphone','required' => false))
            ;
            
          
           
        
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'account';
    }
}
