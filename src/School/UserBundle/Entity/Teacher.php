<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 */
class Teacher
{

    private $id;
    
    protected $courseClasses;

    private $user;
    
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
     * @return Teacher
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


    /**
     * Set user
     *
     * @param \School\UserBundle\Entity\User $user
     * @return Teacher
     */
    public function setUser(\School\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \School\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
