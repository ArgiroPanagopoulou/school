<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CourseRepository extends EntityRepository
{
    public function loadCoursesBySchoolYear()
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT  c.name, s.name as year FROM SchoolUserBundle:Course c LEFT JOIN c.schoolYear s ');
        $coursesBySchoolYear = $q->getResult();
        
        return $coursesBySchoolYear;
    }
}