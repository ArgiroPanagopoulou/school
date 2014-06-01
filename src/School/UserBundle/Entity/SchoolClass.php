<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class
 */
class SchoolClass
{
    /**
     * @var integer
     */
    private $id;
    
    private $name;
    
    protected $schoolYear;

    protected $students;
    
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
     * Set school_year
     *
     * @param \School\UserBundle\Entity\SchoolYear $schoolYear
     * @return SchoolClass
     */
    public function setSchoolYear(\School\UserBundle\Entity\SchoolYear $schoolYear = null)
    {
        $this->school_year = $schoolYear;

        return $this;
    }

    /**
     * Get school_year
     *
     * @return \School\UserBundle\Entity\SchoolYear 
     */
    public function getSchoolYear()
    {
        return $this->school_year;
    }

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
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
}
