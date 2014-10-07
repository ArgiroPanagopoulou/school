<?php

namespace School\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();
            
            
            
            try {
                $user = $q->getSingleResult();
            } catch (NoResultException $e) {
                $message = sprintf(
                    'Unable to find an active admin AcmeUserBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }
        
        return $user;
    }
    
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }
    
    public function loadUsers()
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT u.id, u.username, r.name, r.role FROM SchoolUserBundle:User u LEFT JOIN u.role r');
        $users = $q->getResult();
        
        return $users;           
    }
    
    public function loadUserById($id)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->select('u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
            
         try {
                $user = $q->getSingleResult();
            } catch (NoResultException $e) {
                $message = sprintf(
                    'Unable to find a user',
                $id
            );
            throw new UsernameNotFoundException($message, 0, $e);
            }
        return $user;
    }
    
    // Returns the actual query used for pagination of the users list
    public function loadAllUsers()
    {
        $users = $this->getEntityManager()->createQuery(
            'SELECT u FROM SchoolUserBundle:User u 
            LEFT JOIN u.role r 
            ORDER BY u.lastName ASC'
        );
        
        return $users;
    }
}