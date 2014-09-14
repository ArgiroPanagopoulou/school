<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExamQuestion
 */
class ExamQuestion
{


    private $id;

    private $name;

    private $answerOne;

    private $answerTwo;

    private $answerThree;

    private $answerFour;

    private $correct;

    private $points;

    private $exam;

    private $takenQuestions;

    
    
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
     * Set name
     *
     * @param string $name
     * @return ExamQuestion
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
     * Set answerOne
     *
     * @param string $answerOne
     * @return ExamQuestion
     */
    public function setAnswerOne($answerOne)
    {
        $this->answerOne = $answerOne;

        return $this;
    }

    /**
     * Get answerOne
     *
     * @return string 
     */
    public function getAnswerOne()
    {
        return $this->answerOne;
    }

    /**
     * Set answerTwo
     *
     * @param string $answerTwo
     * @return ExamQuestion
     */
    public function setAnswerTwo($answerTwo)
    {
        $this->answerTwo = $answerTwo;

        return $this;
    }

    /**
     * Get answerTwo
     *
     * @return string 
     */
    public function getAnswerTwo()
    {
        return $this->answerTwo;
    }

    /**
     * Set answerThree
     *
     * @param string $answerThree
     * @return ExamQuestion
     */
    public function setAnswerThree($answerThree)
    {
        $this->answerThree = $answerThree;

        return $this;
    }

    /**
     * Get answerThree
     *
     * @return string 
     */
    public function getAnswerThree()
    {
        return $this->answerThree;
    }

    /**
     * Set answerFour
     *
     * @param string $answerFour
     * @return ExamQuestion
     */
    public function setAnswerFour($answerFour)
    {
        $this->answerFour = $answerFour;

        return $this;
    }

    /**
     * Get answerFour
     *
     * @return string 
     */
    public function getAnswerFour()
    {
        return $this->answerFour;
    }


    /**
     * Set points
     *
     * @param integer $points
     * @return ExamQuestion
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set exam
     *
     * @param \School\UserBundle\Entity\Exam $exam
     * @return ExamQuestion
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
     * Set correct
     *
     * @param integer $correct
     * @return ExamQuestion
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * Get correct
     *
     * @return integer 
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Add takenQuestions
     *
     * @param \School\UserBundle\Entity\TakenQuestion $takenQuestions
     * @return ExamQuestion
     */
    public function addTakenQuestion(\School\UserBundle\Entity\TakenQuestion $takenQuestions)
    {
        $this->takenQuestions[] = $takenQuestions;

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
}
