<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teacher
 */
class Teacher
{
    /**
     * @var integer
     */
    private $id;

    protected $users;
    
    protected $courseClasses;
    
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
     * Set users
     *
     * @param \School\UserBundle\Entity\User $users
     * @return Teacher
     */
    public function setUsers(\School\UserBundle\Entity\User $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \School\UserBundle\Entity\User 
     */
    public function getUsers()
    {
        return $this->users;
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
}
