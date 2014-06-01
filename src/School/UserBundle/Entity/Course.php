<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 */
class Course
{
    /**
     * @var integer
     */
    private $id;
    
    private $name;
    
    protected $schoolYear;


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
}
