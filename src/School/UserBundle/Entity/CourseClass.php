<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseClass
 */
class CourseClass
{

    private $id;
    
    protected $teacher;

    private $course;
 
    private $class;

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set course
     *
     * @param \School\UserBundle\Entity\Course $course
     * @return CourseClass
     */
    public function setCourse(\School\UserBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \School\UserBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }


    /**
     * Set class
     *
     * @param \School\UserBundle\Entity\SchoolClass $class
     * @return CourseClass
     */
    public function setClass(\School\UserBundle\Entity\SchoolClass $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \School\UserBundle\Entity\SchoolClass 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set teacher
     *
     * @param \School\UserBundle\Entity\Teacher $teacher
     * @return CourseClass
     */
    public function setTeacher(\School\UserBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \School\UserBundle\Entity\Teacher 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}
