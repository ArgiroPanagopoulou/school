<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AssignedExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            
        $builder->add('start', 'datetime', array(
            'widget' => 'single_text',
            'format' =>'dd/MM/yyyy HH:mm',
        ));
        $builder->add('stop', 'datetime', array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy HH:mm',
        ));
        
        $builder->add('duration', 'text');
        
        $builder->add('save', 'submit');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\AssignedExam',
        ));
    }
    
    public function getName()
    {
        return 'assigned_exam';
    }
}