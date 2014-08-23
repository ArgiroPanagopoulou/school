<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exam
 */
class Exam
{

    private $id;

    private $name;

    private $course;

    private $examQuestions;
    
    
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
     * @return Exam
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
     * Set course
     *
     * @param \School\UserBundle\Entity\Course $course
     * @return Exam
     */
    public function setCourse(\School\UserBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \School\UserBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->examQuestions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add examQuestions
     *
     * @param \School\UserBundle\Entity\ExamQuestion $examQuestions
     * @return Exam
     */
    public function addExamQuestion(\School\UserBundle\Entity\ExamQuestion $examQuestions)
    {
        $this->examQuestions[] = $examQuestions;
        $examQuestions->setExam($this);
        return $this;
    }

    /**
     * Remove examQuestions
     *
     * @param \School\UserBundle\Entity\ExamQuestion $examQuestions
     */
    public function removeExamQuestion(\School\UserBundle\Entity\ExamQuestion $examQuestion)
    {
        $this->examQuestions->removeElement($examQuestion);
    }

    /**
     * Get examQuestions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExamQuestions()
    {
        return $this->examQuestions;
    }
}
