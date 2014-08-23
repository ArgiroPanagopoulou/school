<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ExamQuestionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    
        $builder->add('name');
        
        $builder->add('examQuestions', 'collection', array(
            'type' => new QuestionsType(),
            'allow_add'    => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));
        
        $builder->add('save', 'submit');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Exam',
            'cascade_validation' => true,
        ));
    }
    
    public function getName()
    {
        return 'exam';
    }
}