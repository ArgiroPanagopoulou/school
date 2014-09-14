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
    
    public function findCoursesByTeacher($teacher)
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT c 
                FROM SchoolUserBundle:Course c 
                LEFT JOIN c.courseClasses s 
                WHERE s.teacher = :teacher'
            )->setParameter('teacher', $teacher);
        $courses = $q->getResult();
        
        return $courses;
    }
    
    public function findClassByTeacher($teacher)
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT s
                FROM SchoolUserBundle:SchoolClass s 
                LEFT JOIN s.courseClasses c
                WHERE c.teacher = :teacher'
            )->setParameter('teacher', $teacher);
            
        $classes = $q->getResult();
        
        return $classes;
    }
    
}