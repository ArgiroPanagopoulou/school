<?php
namespace School\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class TeacherRepository extends EntityRepository
{
    public function loadTeacherByUsername()
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT t, u FROM SchoolUserBundle:Teacher t LEFT JOIN t.user u');
        $teachers = $q->getResult();
        
        return $teachers;
            
    }
    
}