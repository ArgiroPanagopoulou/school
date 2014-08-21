<?php

namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LectureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('file', 'file', array(
                'required' => false,
                'file_path' => 'webPath'
            ));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Lecture',
        ));
    }   
    
    public function getName()
    {
        return 'lecture';
    }
}