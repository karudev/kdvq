<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title','text',array('label' => 'Titre'))
                ->add('address','text',array('label' => 'Adresse'))
                ->add('additionalAddress', 'text', array('label' => 'Complément d\'adresse','required' => false))
                ->add('zipCode','text',array('label' => 'Code postal'))
                ->add('city','text',array('label' => 'Ville'))
                ->add('country','text',array('label' => 'Pays'))
                ->add('type','hidden')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            
            'data_class' => 'Sf\UserBundle\Entity\Address'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'address';
    }

}
