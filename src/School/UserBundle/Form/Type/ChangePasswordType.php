<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', 'password');
        $builder->add('newPassword', 'repeated', array(
            'first_name' => 'newPassword',
            'second_name' => 'confirm',
            'required' => true,
            'invalid_message' => 'The password fields must match.',
            'type' => 'password',
        ));
        
        $builder->add('save', 'submit');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Form\Model\ChangePassword',
        ));
    }
    
    public function getName()
    {
        return 'change_password';
    }
}