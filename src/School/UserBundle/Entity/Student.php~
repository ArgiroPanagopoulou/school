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
    
    protected $users;
    
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
     * Set users
     *
     * @param \School\UserBundle\Entity\User $users
     * @return Student
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
}
