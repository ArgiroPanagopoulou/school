<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 */
class Course
{
    /**
     * @var integer
     */
    private $id;
    
    private $name;
    
    protected $schoolYear;

    private $courseClasses;
    
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
     * Set name
     *
     * @param string $name
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set schoolYear
     *
     * @param \School\UserBundle\Entity\SchoolYear $schoolYear
     * @return Course
     */
    public function setSchoolYear(\School\UserBundle\Entity\SchoolYear $schoolYear = null)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return \School\UserBundle\Entity\SchoolYear 
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courseClasses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add courseClasses
     *
     * @param \School\UserBundle\Entity\CourseClass $courseClasses
     * @return Course
     */
    public function addCourseClass(\School\UserBundle\Entity\CourseClass $courseClasses)
    {
        $this->courseClasses[] = $courseClasses;

        return $this;
    }

    /**
     * Remove courseClasses
     *
     * @param \School\UserBundle\Entity\CourseClass $courseClasses
     */
    public function removeCourseClass(\School\UserBundle\Entity\CourseClass $courseClasses)
    {
        $this->courseClasses->removeElement($courseClasses);
    }

    /**
     * Get courseClasses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourseClasses()
    {
        return $this->courseClasses;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
