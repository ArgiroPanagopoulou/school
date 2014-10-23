<?php
namespace School\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class AssignedExamRepository extends EntityRepository
{
    
    public function findAssignedExamsByCourseClass($course, $class)
    {
        $assigned_exams = $this->getEntityManager()
            ->createQuery("SELECT a 
                FROM SchoolUserBundle:AssignedExam a
                LEFT JOIN a.takenExams t 
                LEFT JOIN a.exam e 
                WHERE a.schoolClass = :class 
                    AND e.course = :course 
                    AND CURRENT_TIMESTAMP() >= a.start 
                    AND CURRENT_TIMESTAMP() <= a.stop" 
            )->setParameter('class', $class)
            ->setParameter('course', $course)
        ->getResult();
        
        return $assigned_exams;
    }
    
    public function findTakenExamsForStudent($student, $class, $course)
    {
        $taken_exams = $this->getEntityManager()
            ->createQuery("SELECT a  
                FROM SchoolUserBundle:AssignedExam a  
                LEFT JOIN a.takenExams t  
                LEFT JOIN a.exam e 
                WHERE t.student = :student 
                    AND a.schoolClass = :class 
                    AND e.course = :course 
                    AND (t.score IS NOT NULL OR t.endTime <= CURRENT_TIMESTAMP())"
            )->setParameter('student', $student)
            ->setParameter('class', $class)
            ->setParameter('course', $course)
        ->getResult();
        
        return $taken_exams;
    }

}