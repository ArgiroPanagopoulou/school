<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class LecturesForCourseClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder->add('course', 'entity', array(
            // 'class' => 'School\UserBundle\Entity\CourseClass',
            // 'query_builder' => function(EntityRepository $er) use ($options) {
                // return $er->createQueryBuilder('c')
                    // ->where('c.id = :id')
                    // ->setParameter('id', $options['id']);
            // },
            // 'property' => 'course.name',
        // ));

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
            'data_class' => 'School\UserBundle\Entity\CourseClass',
            'cascade_validation' => true,
        ));
    }
    
    public function getName()
    {
        return 'lecturesForCourseClass';
    }
}