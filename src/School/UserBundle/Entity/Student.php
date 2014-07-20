<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 */
class Student
{
    /**
     * @var integer
     */
    private $id;

    private $registrationDate;
    
    protected $user;
    
    protected $schoolClass;
    
    
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
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     * @return Student
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime 
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set user
     *
     * @param \School\UserBundle\Entity\User $user
     * @return Student
     */
    public function setUser(\School\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get users
     *
     * @return \School\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set schoolClass
     *
     * @param \School\UserBundle\Entity\SchoolClass $schoolClass
     * @return Student
     */
    public function setSchoolClass(\School\UserBundle\Entity\SchoolClass $schoolClass = null)
    {
        $this->schoolClass = $schoolClass;

        return $this;
    }

    /**
     * Get schoolClass
     *
     * @return \School\UserBundle\Entity\SchoolClass 
     */
    public function getSchoolClass()
    {
        return $this->schoolClass;
    }
    /**
     * @var \School\UserBundle\Entity\User
     */
    private $user_student;


    /**
     * Set user_student
     *
     * @param \School\UserBundle\Entity\User $userStudent
     * @return Student
     */
    public function setUserStudent(\School\UserBundle\Entity\User $userStudent = null)
    {
        $this->user_student = $userStudent;

        return $this;
    }

    /**
     * Get user_student
     *
     * @return \School\UserBundle\Entity\User 
     */
    public function getUserStudent()
    {
        return $this->user_student;
    }
}
