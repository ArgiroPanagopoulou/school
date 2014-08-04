<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;

class StudentRemovalFromClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('select', 'hidden', array(
            'data' => join(",", $options['selected_students']),
            'mapped' => false,
        ));
        
        $builder->add('studentAction', 'hidden', array(
            'data' => $options['selected_action'],
            'mapped' => false,
        ));
        
        $builder->add('Confirm', 'submit');
    }
    
    public function getName()
    {
        return 'schoolClassTest';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Student',
            'selected_students' => null,
            'selected_action' => null,
        ));
    }
}