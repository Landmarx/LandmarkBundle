<?php
namespace Landmarx\Bundle\LandmarkBundle\Form\Type;

use \Symfony\Component\Form\FormBuilderInterface;

class LandmarkFormType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description');
        $builder->add('brief description');
        $builder->add(
            'type',
            'document',
            array(
                'property' =>  'name',
                'class' => 'Landmarx\Bundle\LandmarkBundle\Model\Type'
           )
        );
        $builder->add(
            'parent',
            'document',
            array(
                    'property' =>  'name',
                    'class' => 'Landmarx\Bundle\LandmarkBundle\Model\Landmark'
           )
        );
        $builder->add(
            'location',
            'document',
            array(
                'property' => name,
                'class' => 'Landmarx\Bundle\LocationBundle\Model\Location'
            )
        );
        $builder->add(
            'visibility',
            'checkbox',
            array(
                'label'     => 'Show this landmark publicly?',
                'required'  => false,
          )
        );
        $builder->add('created_by', 'hidden');
        $builder->add('updated_by', 'hidden');
    }

    public function getName()
    {
          return 'landmark';
    }
}
