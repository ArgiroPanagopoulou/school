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
    
    public function findTakenExamsByStudentCourse($student, $course)
    {
        $taken_exams = $this->getEntityManager()
            ->createQuery('SELECT t 
                FROM SchoolUserBundle:TakenExam t 
                LEFT JOIN t.exam e 
                WHERE t.student = :student AND e.course = :course'
            )->setParameter('student', $student)
            ->setParameter('course', $course)
        ->getResult();
        
        return $taken_exams;
    }
    
    public function findTakenExamsByStudent($student)
    {
        $taken_exams = $this->getEntityManager()
            ->createQuery('SELECT t 
                FROM SchoolUserBundle:TakenExam t 
                WHERE t.student = :student
                ORDER BY t.startTime DESC'
            )->setParameter('student', $student)
        ->getResult();
        
        return $taken_exams;
    }
}