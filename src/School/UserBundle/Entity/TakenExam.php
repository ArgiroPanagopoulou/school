<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TakenExam
 */
class TakenExam
{

    private $id;

    private $student;

    private $exam;

    private $takenQuestions;

    private $assignedExam;

    private $score;
    
    public static $points = 0;
    
    /**
    * Constructor
    */
    public function __construct()
    {
        $this->takenQuestions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set student
     *
     * @param \School\UserBundle\Entity\Student $student
     * @return TakenExam
     */
    public function setStudent(\School\UserBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \School\UserBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set exam
     *
     * @param \School\UserBundle\Entity\Exam $exam
     * @return TakenExam
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
     * Add takenQuestions
     *
     * @param \School\UserBundle\Entity\TakenQuestion $takenQuestions
     * @return TakenExam
     */
    public function addTakenQuestion(\School\UserBundle\Entity\TakenQuestion $takenQuestion)
    {
        $this->takenQuestions[] = $takenQuestion;

        return $this;
    }

    /**
     * Remove takenQuestions
     *
     * @param \School\UserBundle\Entity\TakenQuestion $takenQuestions
     */
    public function removeTakenQuestion(\School\UserBundle\Entity\TakenQuestion $takenQuestions)
    {
        $this->takenQuestions->removeElement($takenQuestions);
    }

    /**
     * Get takenQuestions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTakenQuestions()
    {
        return $this->takenQuestions;
    }


    /**
     * Set assignedExam
     *
     * @param \School\UserBundle\Entity\AssignedExam $assignedExam
     * @return TakenExam
     */
    public function setAssignedExam(\School\UserBundle\Entity\AssignedExam $assignedExam = null)
    {
        $this->assignedExam = $assignedExam;

        return $this;
    }

    /**
     * Get assignedExam
     *
     * @return \School\UserBundle\Entity\AssignedExam 
     */
    public function getAssignedExam()
    {
        return $this->assignedExam;
    }

    public static function calculateScore($answer, $question)
    {
        
        if($answer == $question->getCorrect()) {
            self::$points = self::$points + $question->getPoints();
        }
        return self::$points;
    }

    /**
     * Set score
     *
     * @return TakenExam
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }
}
