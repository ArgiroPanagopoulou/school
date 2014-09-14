<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class LecturesForCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('lectures', 'collection', array(
            'type' => new LectureType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));
        
        $builder->add('save', 'submit');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Course',
            'cascade_validation' => true,
        ));
    }
    
    public function getName()
    {
        return 'lecturesForCourse';
    }
}