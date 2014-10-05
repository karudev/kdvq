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
                'choices' => array('M' => 'Mr', 'MME' => 'Mme', 'MLLE' => 'Mlle'),
                'expanded' => true,
                'required' => false,
                ))
            ->add('firstname')
            ->add('lastname')
            ->add('phone','text',array('required' => false))
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
