<?php
namespace School\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use School\UserBundle\Form\Transformer\RoleToNumberTransformer;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\SecurityContext;

class UserType extends AbstractType
{
    private $securityContext;
    
    public function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Current logged user
        $user = $this->securityContext->getToken()->getUser();
        
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('username')
            ->add('email', 'email')            
            ->add('save', 'submit');

        if($this->securityContext->isGranted('ROLE_ADMIN')) {
            $builder->add('role', 'entity', array(
                'class' => 'School\UserBundle\Entity\Role',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r');
                },
                'property' => 'name',
                'expanded' => true,
                'multiple' => false,
            ));
            $builder->add('is_active', 'checkbox', array('label' => 'Active',));
        }
        
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