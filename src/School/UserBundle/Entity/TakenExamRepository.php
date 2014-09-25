<?php
namespace School\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TakenExamRepository extends EntityRepository
{
    public function findTakenByStudentExam($student, $assigned_exam)
    {
        $taken_exam = $this->getEntityManager()
            ->createQuery('SELECT t 
                FROM SchoolUserBundle:TakenExam t
                WHERE t.assignedExam = :assigned_exam AND t.student = :student
            ')->setParameter('assigned_exam', $assigned_exam)
            ->setParameter('student', $student)
        ->getOneOrNullResult();
        
        return $taken_exam;
    }
}