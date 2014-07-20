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
    
    
    
}