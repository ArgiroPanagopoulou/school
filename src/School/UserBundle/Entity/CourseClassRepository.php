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

    
}