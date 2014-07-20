<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class CourseClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('course', 'entity', array(
            'class' => 'School\UserBundle\Entity\Course',
            'property' => 'name',
            'expanded' => false,
            'multiple' => false,
        ));
        
        $builder->add('class', 'entity', array(
            'class' => 'School\UserBundle\Entity\SchoolClass',
            'property' => 'name',
            'expanded' => false,
            'multiple' => false,
        ));
        
        $builder->add('teacher', 'entity', array(
            'class' => 'School\UserBundle\Entity\Teacher',
            'property' => 'user.username',
            'expanded' => false,
            'multiple' => false,
        ));
        
        $builder->add('save', 'submit');

    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\CourseClass'
        ));
    }
    
    public function getName()
    {
        return 'courseClass';
    }
}