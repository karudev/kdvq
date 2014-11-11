<?php

namespace Sf\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CategoryType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('picture', 'file', array('required' => false))
                 ->add('category', 'entity', array(
                    'property' => 'name',
                    'class' => 'SfAdminBundle:Category',
                    'required' => false,
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('e')
                        ->where('e.category is null')
                        ->orderBy('e.name', 'ASC');
                    })
                    )
                //->add('picture', 'file', array('required' => false))
                ->add('name', 'text', array('required' => false))
                ->add('active', 'checkbox', array('required' => false))

        ;
    }

    

    /**
     * @return string
     */
    public function getName() {
        return 'category';
    }

}
