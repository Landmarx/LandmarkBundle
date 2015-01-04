<?php
namespace Landmarx\Bundle\LandmarkBundle\Form\Type;

use \Symfony\Component\Form\FormBuilderInterface;

class LandmarkSearchFormType extends \Symfony\Component\Form\AbstractType
{
    /**
     * Build form
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fields = array('name', 'description', 'all' => 'name AND o.description');
        
        $builder->add('query');
        $builder->add(
            'type',
            'choice',
            array(
                'choices' => $fields
            )
        );
        
    }
    
    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return 'landmarx_landmark_search';
    }
}
