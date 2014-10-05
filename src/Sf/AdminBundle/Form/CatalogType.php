<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $choices = array();
        for ($i = date('Y') + 2; $i > date('Y') - 20; $i --) {
            $choices[$i] = $i.' - '.($i+1);
        }


        $builder
                ->add('brand', 'entity', array(
                    'class' => 'SfAdminBundle:Brand',
                    'property' => 'name'))
                ->add('file', 'file', array('required' => false))
                ->add('year', 'choice', array('choices' => $choices))

        ;
    }

    /**
     * @return string
     */
    public function getName() {
        return 'catalog';
    }

}
