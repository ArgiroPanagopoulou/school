<?php
namespace School\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AssignedExamRepository extends EntityRepository
{
    
    public function findAssignedExamsByCourseClass($course, $class)
    {
        $assigned_exams = $this->getEntityManager()
            ->createQuery('SELECT a 
                FROM SchoolUserBundle:AssignedExam a 
                LEFT JOIN a.exam e 
                WHERE a.schoolClass = :class AND e.course = :course' 
            )->setParameter('class', $class)
            ->setParameter('course', $course)
        ->getResult();
        
        return $assigned_exams;
    }
    
    public function findTakenExamsForStudent($student, $class, $course)
    {
        $taken_exams = $this->getEntityManager()
            ->createQuery('SELECT a  
                FROM SchoolUserBundle:AssignedExam a  
                LEFT JOIN a.takenExams t  
                LEFT JOIN a.exam e 
                WHERE t.student = :student AND a.schoolClass = :class AND e.course = :course'
            )->setParameter('student', $student)
            ->setParameter('class', $class)
            ->setParameter('course', $course)
        ->getResult();
        
        return $taken_exams;
    }

}