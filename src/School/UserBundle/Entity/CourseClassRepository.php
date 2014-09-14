<?php
namespace School\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CourseClassRepository extends EntityRepository
{
    public function loadCourseClasses()
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT c FROM SchoolUserBundle:CourseClass c'
            );
        $courses = $q->getResult();
        
        return $courses;
    }
    
    public function findCourseClassById($course, $class)
    {
        $course_class = $this->getEntityManager()
            ->createQuery('SELECT c 
                FROM SchoolUserBundle:CourseClass c 
                WHERE c.course = :course AND
                c.class = :class'
            )->setParameter('course', $course)
            ->setParameter('class', $class)
            ->getOneOrNullResult();
        return $course_class;
    }

    public function findCoursesByTeacher($teacher)
    {
        $course_classes = $this->getEntityManager()
            ->createQuery('SELECT c 
                FROM SchoolUserBundle:CourseClass c 
                    LEFT JOIN c.course course 
                    LEFT JOIN course.schoolYear schoolYear
                WHERE c.teacher = :teacher
                ORDER BY schoolYear.id, c.course'
            )->setParameter('teacher', $teacher)
            ->getResult();
        
        return $course_classes;
    }
}