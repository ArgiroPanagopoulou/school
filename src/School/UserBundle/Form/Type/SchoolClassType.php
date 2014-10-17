<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class SchoolClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'entity', array(
                'class' => 'SchoolUserBundle:SchoolClass',
                'query_builder' => function(EntityRepository $er) use($options) {
                    return $er->createQueryBuilder('u')
                        ->where('u.schoolYear = :year')
                        ->setParameter('year', $options['year']);
                },
                'property' => 'name',
            ))
            ->add('save', 'submit');
    }
    
    public function getName()
    {
        return 'schoolClass';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\SchoolClass',
            'year' => null,
        ));
    }
}