<?php
namespace Landmarx\Bundle\LandmarkBundle\Form\Type;

use \Symfony\Component\Form\AbstractType;
use \Symfony\Component\Form\FormBuilderInterface;

use \Landmarx\Bundle\LandmarkBundle\Document\Type;

class TypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description');
        $builder->add(
            'parent',
            'entity',
            array(
                'property' =>  'name',
                'class' => 'Landmarx\Bundle\LandmarkBundle\Document\Type',
                'required' => false
           )
        );
        $builder->add(
            'public',
            'checkbox',
            array(
                'label'     => 'Show this entry publicly?',
                'required'  => false,
           )
        );
    }

    public function getName()
    {
        return 'type';
    }
}
