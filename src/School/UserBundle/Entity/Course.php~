<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 */
class Course
{

    private $id;
    
    private $name;
    
    protected $schoolYear;

    private $courseClasses;

    private $exams;

    private $lectures;
   
   
    /**
    * Constructor
    */
    public function __construct()
    {
        $this->courseClasses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->exams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Course
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
     * Set schoolYear
     *
     * @param \School\UserBundle\Entity\SchoolYear $schoolYear
     * @return Course
     */
    public function setSchoolYear(\School\UserBundle\Entity\SchoolYear $schoolYear = null)
    {
        $this->schoolYear = $schoolYear;

        return $this;
    }

    /**
     * Get schoolYear
     *
     * @return \School\UserBundle\Entity\SchoolYear 
     */
    public function getSchoolYear()
    {
        return $this->schoolYear;
    }


    /**
     * Add courseClasses
     *
     * @param \School\UserBundle\Entity\CourseClass $courseClasses
     * @return Course
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
     * Add exams
     *
     * @param \School\UserBundle\Entity\Exam $exams
     * @return Course
     */
    public function addExam(\School\UserBundle\Entity\Exam $exams)
    {
        $this->exams[] = $exams;
        $exams->setCourse($this);

        return $this;
    }

    /**
     * Remove exams
     *
     * @param \School\UserBundle\Entity\Exam $exams
     */
    public function removeExam(\School\UserBundle\Entity\Exam $exam)
    {
        $this->exams->removeElement($exam);
    }

    /**
     * Get exams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExams()
    {
        return $this->exams;
    }
    

    /**
     * Add lectures
     *
     * @param \School\UserBundle\Entity\Lecture $lectures
     * @return Course
     */
    public function addLecture(\School\UserBundle\Entity\Lecture $lectures)
    {
        $this->lectures[] = $lectures;
        $lectures->setCourse($this);

        return $this;
    }

    /**
     * Remove lectures
     *
     * @param \School\UserBundle\Entity\Lecture $lectures
     */
    public function removeLecture(\School\UserBundle\Entity\Lecture $lecture)
    {
        $this->lectures->removeElement($lecture);
    }

    /**
     * Get lectures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLectures()
    {
        return $this->lectures;
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
