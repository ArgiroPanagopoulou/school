<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', 'entity', array(
            'class' => 'School\UserBundle\Entity\User',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.role = 3'); //WRONG!!!! TO BE CHANGED
            },
            'property' => 'username',
            'expanded' => false,
            'multiple' => false,
        ));
        $builder->add('save', 'submit');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Teacher',
            'id' => null,
            'cascade_validation' => true,
        ));
    }
    
    public function getName()
    {
        return 'teacher';
    }
}