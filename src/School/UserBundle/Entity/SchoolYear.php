<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SchoolYear
 */
class SchoolYear
{
    /**
     * @var integer
     */
    private $id;

    private $name;
    
    private $dateFrom;
    
    private $dateTo;

    private $schoolClasses;
    
    private $courses;
    

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
     * @return SchoolYear
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
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     * @return SchoolYear
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     * @return SchoolYear
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime 
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }
   

    /**
     * Add schoolClasses
     *
     * @param \School\UserBundle\Entity\SchoolClass $schoolClasses
     * @return SchoolYear
     */
    public function addSchoolClass(\School\UserBundle\Entity\SchoolClass $schoolClasses)
    {
        //$this->schoolClasses[] = $schoolClasses;
        $this->schoolClasses[] = $schoolClasses;
        $schoolClasses->setSchoolYear($this);
        return $this;
    }

    /**
     * Remove schoolClasses
     *
     * @param \School\UserBundle\Entity\SchoolClass $schoolClasses
     */
    public function removeSchoolClass(\School\UserBundle\Entity\SchoolClass $schoolClass)
    {
        $this->schoolClasses->removeElement($schoolClass);
    }

    /**
     * Get schoolClasses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchoolClasses()
    {
        return $this->schoolClasses;
    }
    
    public function __toString()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schoolClasses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add courses
     *
     * @param \School\UserBundle\Entity\Course $courses
     * @return SchoolYear
     */
    public function addCourse(\School\UserBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \School\UserBundle\Entity\Course $courses
     */
    public function removeCourse(\School\UserBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->courses;
    }
}
