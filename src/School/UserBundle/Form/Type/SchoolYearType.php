<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SchoolYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'entity', array(
                'class' => 'SchoolUserBundle:SchoolYear',
                'property' => 'name',
                'expanded' => false,
                'multiple' => false,
            ))
            // ->add('dateFrom')
            // ->add('dateTo')
            ->add('save', 'submit');
    }
    
    public function getName()
    {
        return 'schoolYear';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\SchoolYear',
        ));
    }
}