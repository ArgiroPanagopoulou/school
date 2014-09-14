<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'entity', array(
            'class' => 'SchoolUserBundle:Exam',
            'empty_value' => '- Choose an exam -',
            'choices' => $options['non_assigned_exams'],
            'property' => 'name',
            'label' => 'Available Exams',
        ));

        $builder->add('Assign', 'submit');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Exam',
            'non_assigned_exams' => null,
        ));
    }
    
    public function getName()
    {
        return 'assigned_exam';
    }
}