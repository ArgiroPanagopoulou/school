<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TakenQuestion
 */
class TakenQuestion
{

    private $id;

    private $answer;

    private $takenExam;

    private $examQuestion;

    
    
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
     * Set answer
     *
     * @param integer $answer
     * @return TakenQuestion
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return integer 
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set takenExam
     *
     * @param \School\UserBundle\Entity\TakenExam $takenExam
     * @return TakenQuestion
     */
    public function setTakenExam(\School\UserBundle\Entity\TakenExam $takenExam = null)
    {
        $this->takenExam = $takenExam;

        return $this;
    }

    /**
     * Get takenExam
     *
     * @return \School\UserBundle\Entity\TakenExam 
     */
    public function getTakenExam()
    {
        return $this->takenExam;
    }

    /**
     * Set examQuestion
     *
     * @param \School\UserBundle\Entity\ExamQuestion $examQuestion
     * @return TakenQuestion
     */
    public function setExamQuestion(\School\UserBundle\Entity\ExamQuestion $examQuestion = null)
    {
        $this->examQuestion = $examQuestion;

        return $this;
    }

    /**
     * Get examQuestion
     *
     * @return \School\UserBundle\Entity\ExamQuestion 
     */
    public function getExamQuestion()
    {
        return $this->examQuestion;
    }
}
