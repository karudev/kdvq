<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class CriterionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //var_dump($options['data']);die();
        $builder
           
            ->add('type','choice',array(
                'data' => $options['data']['type'],
                'mapped' => false,'choices' => 
                array('T' => 'Tailles',
                    'C' => 'Couleurs',
                    'M' => 'Matériaux',
                    'N' => 'Numéros'
                    )))
            ->add('name','text', array( 'data' => $options['data']['name'],'required' => true))
            ->add('active','checkbox', array( 'data' => $options['data']['active'],'attr' => array('checked' => true),'required' => false));

          
          
           
        
    }

    

    /**
     * @return string
     */
    public function getName()
    {
        return 'criterion';
    }
}
