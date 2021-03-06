<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AssignedExam
 */
class AssignedExam
{

    private $id;

    private $takenExams;

    private $exam;

    private $schoolClass;

    private $dateCreated;

    private $start;

    private $stop;

    private $duration;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->takenExams = new \Doctrine\Common\Collections\ArrayCollection();
        // Sets the current date
        $this->dateCreated = new \DateTime();
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
     * Add takenExams
     *
     * @param \School\UserBundle\Entity\TakenExam $takenExams
     * @return AssignedExam
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

    /**
     * Set exam
     *
     * @param \School\UserBundle\Entity\Exam $exam
     * @return AssignedExam
     */
    public function setExam(\School\UserBundle\Entity\Exam $exam = null)
    {
        $this->exam = $exam;

        return $this;
    }

    /**
     * Get exam
     *
     * @return \School\UserBundle\Entity\Exam 
     */
    public function getExam()
    {
        return $this->exam;
    }

    /**
     * Set schoolClass
     *
     * @param \School\UserBundle\Entity\SchoolClass $schoolClass
     * @return AssignedExam
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return AssignedExam
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     * @return AssignedExam
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set stop
     *
     * @param \DateTime $stop
     * @return AssignedExam
     */
    public function setStop($stop)
    {
        $this->stop = $stop;

        return $this;
    }
    
    public function isStartDateValid()
    {
        return true;
        //return $this->start >= new \DateTime();
    }
    
    public function isStopDateValid()
    {
        return $this->stop > $this->start;
    }
    
    /**
     * Get stop
     *
     * @return \DateTime 
     */
    public function getStop()
    {
        return $this->stop;
    }


    /**
     * Set duration
     *
     * @param string $duration
     * @return AssignedExam
     */
    public function setDuration($duration)
    {
        // converts the duration into seconds
        $str_time = $duration;
        
        sscanf($str_time, "%d:%d", $hours, $minutes);

        $duration = $hours * 3600 + $minutes * 60;
        
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        $duration = gmdate("H:i", $this->duration);
        return $duration;
    }
}
