<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use School\UserBundle\Form\Transformer\RoleToNumberTransformer;

class UserType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('username')
            ->add('password', 'password')
            ->add('email', 'email')
            ->add('isActive', 'checkbox', array('label' => 'Active',))
            ->add('roles', 'collection', array('type' => new RoleType(),))
                // 'allow_add'    => true,))
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