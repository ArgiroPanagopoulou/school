<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use School\UserBundle\Entity\Role;


class RoleType extends AbstractType
{
  
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
            ->add('name')
            ->add('role');
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'School\UserBundle\Entity\Role',
        ));
    }
    

    public function getName()
    {
        return 'role';
    }
}