<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseClass
 */
class CourseClass
{
    /**
     * @var integer
     */
    private $id;
    
    private $course_id;
    
    private $class_id;
    
    protected $teacher;


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
     * Set course_id
     *
     * @param integer $courseId
     * @return CourseClass
     */
    public function setCourseId($courseId)
    {
        $this->course_id = $courseId;

        return $this;
    }

    /**
     * Get course_id
     *
     * @return integer 
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Set class_id
     *
     * @param integer $classId
     * @return CourseClass
     */
    public function setClassId($classId)
    {
        $this->class_id = $classId;

        return $this;
    }

    /**
     * Get class_id
     *
     * @return integer 
     */
    public function getClassId()
    {
        return $this->class_id;
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
