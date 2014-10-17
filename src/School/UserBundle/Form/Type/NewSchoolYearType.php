<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewSchoolYearType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dateFrom', 'date', array(
                'widget' => 'single_text',
                'format' =>'dd/MM/yyyy',
            ))
            ->add('dateTo', 'date', array(
                'widget' => 'single_text',
                'format' =>'dd/MM/yyyy',
            ));
        $builder->add('schoolClasses', 'collection', array(
            'type' => new NewSchoolClassType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));
        $builder->add('save', 'submit');
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