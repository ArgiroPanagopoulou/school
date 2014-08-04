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

class StudentAssignationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('schoolYear', 'entity', array(
            'class' => 'SchoolUserBundle:SchoolYear',
            'empty_value' => '- Choose a year -',
            'property' => 'name',
        ));
        
        $builder->add('select', 'hidden', array(
            'data' => join(",", $options['selected_students']),
            'mapped' => false,
        ));
        
        $builder->add('studentAction', 'hidden', array(
            'data' => $options['selected_action'],
            'mapped' => false,
        ));
        
        $builder->add('save', 'submit');
        
        $populate_classes = function (FormInterface $form, SchoolYear $schoolyear = null) {
            
            $year_classes = (null === $schoolyear)? 
                 array(): 
                 $schoolyear->getSchoolClasses();

            $form->add('name', 'entity', array(
               'class'       => 'SchoolUserBundle:SchoolClass',
               'empty_value' => (empty($year_classes))? '- Choose a year, first -' : '- Choose a class -',
               'choices'     => $year_classes,
            ));
            
        };
        
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($populate_classes){
                $form = $event->getForm();
                $data = $event->getData();
                $populate_classes($form, $data->getSchoolYear());               
            }
        );
        
        $builder->get('schoolYear')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($populate_classes){
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                
                $schoolyear = $event->getForm()->getData();               
                $populate_classes($event->getForm()->getParent(), $schoolyear);
            }
        );
    }
        
    
    public function getName()
    {
        return 'schoolClassTest';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\SchoolClass',
            'validation_groups' => false,
            'selected_students' => null,
            'selected_action' => null,
        ));
    }
}