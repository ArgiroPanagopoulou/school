<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('answerOne', 'text', array('label' => 'Answer A:'))
            ->add('answerTwo', 'text', array('label' => 'Answer B:'))
            ->add('answerThree', 'text', array('label' => 'Answer C:'))
            ->add('answerFour', 'text', array('label' => 'Answer D:'))
            ->add('correct', 'choice', array(
                'label' => 'Correct Answer',
                'choices' => array('1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D')))
            ->add('points', 'number', array('label' => 'Points'));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\ExamQuestion',
        ));
    }
    
    public function getName()
    {
        return 'questions';
    }
}