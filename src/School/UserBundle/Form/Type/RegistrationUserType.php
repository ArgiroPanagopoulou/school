<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', 'text');
        $builder->add('lastName', 'text');
        //$builder->add('username', 'text');
        $builder->add('email', 'email');
        
        $builder->add('password', 'repeated', array(
           'first_name'  => 'password',
           'second_name' => 'confirm',
           'type'        => 'password',
        ));         
        //$builder->add('foo', 'text', array('mapped' => false));
        $builder->add('Register', 'submit');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}