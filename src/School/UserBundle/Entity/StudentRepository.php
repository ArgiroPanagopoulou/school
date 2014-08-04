<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class StudentRepository extends EntityRepository
{
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT s FROM SchoolUserBundle:Student s LEFT JOIN s.user u ORDER BY u.lastName ASC'
            )
            ->getResult();
    }
    
    public function findAllBySchoolClass($schoolClass)
    {
        $students = $this->getEntityManager()
                    ->createQuery(
                        'SELECT s 
                        FROM SchoolUserBundle:Student s
                        LEFT JOIN s.user u 
                        WHERE s.schoolClass = :schoolClass
                        ORDER BY u.lastName ASC'
                    )->setParameter('schoolClass', $schoolClass)
                    ->getResult();
        if ($schoolClass == NULL ) {
            return $this->findAllOrderedByName();
        } else
        return $students;
    }
    
    public function findAllByClassAssignation($assigned)
    {
        $students_assigned = $this->getEntityManager()
            ->createQuery(
                'SELECT s
                FROM SchoolUserBundle:Student s
                LEFT JOIN s.user u
                WHERE s.schoolClass IS NOT NULL
                ORDER BY u.lastName ASC'
            )->getResult();
        $students_notassigned = $this->getEntityManager()
            ->createQuery(
                'SELECT s
                FROM SchoolUserBundle:Student s
                LEFT JOIN s.user u
                WHERE s.schoolClass IS NULL
                ORDER BY u.lastName ASC'
            )->getResult();
        if ($assigned == 'n') {
            return $students_notassigned;
        } elseif ($assigned == 'a') {
            return $students_assigned;
        } elseif ($assigned == NULL) {
            return $this->findAllOrderedByName();
        }
    }
    
    public function findByUserId($id)
    {
        $student = $this->getEntityManager()
            ->createQuery(
                'SELECT s
                FROM SchoolUserBundle:Student s
                LEFT JOIN s.user u
                WHERE u.id = :id'
            )->setParameter('id', $id)
            ->getSingleResult();
        return $student;
    }
}