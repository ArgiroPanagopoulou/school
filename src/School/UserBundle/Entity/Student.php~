<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 */
class Student
{

    private $id;

    private $registrationDate;
    
    protected $user;
    
    protected $schoolClass;

    private $takenExams;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->takenExams = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Add takenExams
     *
     * @param \School\UserBundle\Entity\TakenExam $takenExams
     * @return Student
     */
    public function addTakenExam(\School\UserBundle\Entity\TakenExam $takenExams)
    {
        $this->takenExams[] = $takenExams;

        return $this;
    }

    /**
     * Remove takenExams
     *
     * @param \School\UserBundle\Entity\TakenExam $takenExams
     */
    public function removeTakenExam(\School\UserBundle\Entity\TakenExam $takenExams)
    {
        $this->takenExams->removeElement($takenExams);
    }

    /**
     * Get takenExams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTakenExams()
    {
        return $this->takenExams;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
