<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;
use School\UserBundle\Entity\SchoolClass as SchoolClass;


class StudentFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('schoolClass', 'entity', array(
            'class' => 'SchoolUserBundle:SchoolClass',
            'empty_value' => '- Any -',
            'property' => 'name',
            'required' => false,
        ));
        
        $builder->add('assigned', 'choice', array(
            'choices' => array('a' => 'Assigned to a class', 'n' => 'Not assigned to a class'),
            'required' =>false,
            'empty_value' => '- Any -',
            'mapped' => false,
        ));
        
        
        $builder
            ->add('update', 'submit');
    }
    
    public function getName()
    {
        return 'student_filter';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Student',
        ));
    }
}