<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class StudentExamType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {    
    
        foreach($options['questions'] as $question) {
            $builder->add( sprintf("answers_%d", $question->getId()), 'choice', array(
            'choices' => array(
                '1' => $question->getAnswerOne(), 
                '2' => $question->getAnswerTwo(), 
                '3' => $question->getAnswerThree(), 
                '4' => $question->getAnswerFour(),
            ),
            'label' => $question->getName().' (Points '.$question->getPoints().')',
            'mapped' => false,
            'expanded' => true,
            'multiple' => false,
            'required' => false,
            'empty_data'  => null,
            'empty_value' => 'n/a',
            ));
        }
        
        $builder->add('save', 'submit');
    }

    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\AssignedExam',
            'questions' => null,    
        ));
    }
    
    public function getName()
    {
        return 'assigned_exam';
    }
}