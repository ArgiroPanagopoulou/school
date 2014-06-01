<?php
namespace School\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class RoleRepository extends EntityRepository
{
    public function listRoles()
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT r FROM SchoolUserBundle:Role r');
        $roles = $q->getResult();
        
        return $roles;  
    }
}