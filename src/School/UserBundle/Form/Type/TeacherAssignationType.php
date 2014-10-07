<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use School\UserBundle\Entity\SchoolClass as SchoolClass;
use School\UserBundle\Entity\SchoolYear as SchoolYear;
use School\UserBundle\Entity\Course as Course;
use School\UserBundle\Entity\Teacher as Teacher;

class TeacherAssignationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('schoolyear',
            'entity', array(
            'class' => 'SchoolUserBundle:SchoolYear',
            'empty_value' => '- Choose a year -',
            'property' => 'name',
        ));
        
        $builder->add('save', 'submit');
        
        $populate_courses = function (FormInterface $form, SchoolYear $schoolyear = null) {

            $courses = (null === $schoolyear) ? array() : $schoolyear->getCourses();
            $classes = (null === $schoolyear) ? array() : $schoolyear->getSchoolClasses();
            
            $form->add('courses', 'entity', array(
                'class' => 'SchoolUserBundle:Course',
                'empty_value' => (empty($courses))? '- Choose a year, first -' : '- Choose a course -',
                'choices' => $courses,
            ));
            
            $form->add('schoolClasses', 'entity', array(
                'class' => 'SchoolUserBundle:SchoolClass',
                'empty_value' => (empty($classes))? '- Choose a course, first -' : '- Choose a class -',
                'choices' => $classes,
            ));

            $form->add('teacher', 'entity', array(
                'class' => 'SchoolUserBundle:Teacher',
                'empty_value' => '- Choose a teacher -',
                'property' => 'user.fullName', 
                
            ));
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($populate_courses) {
                $data = $event->getData();
                $populate_courses($event->getForm(), $data->getSchoolYear());
                             
            }
        );
        
        $builder->get('schoolyear')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($populate_courses) {
                $schoolyear = $event->getForm()->getData();
                $populate_courses($event->getForm()->getParent(), $schoolyear);
            }
        );
        
    }
    
    public function getName()
    {
        return 'teacher_assignation';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Form\Model\TeacherAssignation',
        ));
    }
}