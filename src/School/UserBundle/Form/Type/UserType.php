<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use School\UserBundle\Form\Transformer\RoleToNumberTransformer;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('username')
            ->add('email', 'email')
            ->add('is_active', 'checkbox', array('label' => 'Active',))
            ->add('role', 'entity', array(
                'class' => 'School\UserBundle\Entity\Role',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r');
                },
                'property' => 'name',
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('save', 'submit');
           
    }
    
    public function getName()
    {
        return 'user';
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\User',
            'cascade_validation' => true,
        ));
    }
}