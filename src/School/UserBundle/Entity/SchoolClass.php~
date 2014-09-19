<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class
 */
class SchoolClass
{
   
    private $id;
    
    private $name;
    
    protected $schoolYear;

    protected $students;
    
    private $courseClasses;

    private $assignedExams;
        
    /**
    * Constructor
    */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return SchoolClass
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
     * Add students
     *
     * @param \School\UserBundle\Entity\Student $students
     * @return SchoolClass
     */
    public function addStudent(\School\UserBundle\Entity\Student $students)
    {
        $this->students[] = $students;

        return $this;
    }

    /**
     * Remove students
     *
     * @param \School\UserBundle\Entity\Student $students
     */
    public function removeStudent(\School\UserBundle\Entity\Student $students)
    {
        $this->students->removeElement($students);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudents()
    {
        return $this->students;
    }
 

    /**
     * Add courseClasses
     *
     * @param \School\UserBundle\Entity\CourseClass $courseClasses
     * @return SchoolClass
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
     * Set schoolYear
     *
     * @param \School\UserBundle\Entity\SchoolYear $schoolYear
     * @return SchoolClass
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
    
    public function __toString()
    {
        return $this->name;
    }


    /**
     * Add assignedExams
     *
     * @param \School\UserBundle\Entity\AssignedExam $assignedExams
     * @return SchoolClass
     */
    public function addAssignedExam(\School\UserBundle\Entity\AssignedExam $assignedExams)
    {
        $this->assignedExams[] = $assignedExams;

        return $this;
    }

    /**
     * Remove assignedExams
     *
     * @param \School\UserBundle\Entity\AssignedExam $assignedExams
     */
    public function removeAssignedExam(\School\UserBundle\Entity\AssignedExam $assignedExams)
    {
        $this->assignedExams->removeElement($assignedExams);
    }

    /**
     * Get assignedExams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssignedExams()
    {
        return $this->assignedExams;
    }
}
