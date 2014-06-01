<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 */
class Tag
{
    /**
     * @var integer
     */
    private $id;

    protected $name;
    
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
     * @var \School\UserBundle\Entity\Task
     */
    private $task;


    /**
     * Set name
     *
     * @param string $name
     * @return Tag
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
     * Set task
     *
     * @param \School\UserBundle\Entity\Task $task
     * @return Tag
     */
    public function setTask(\School\UserBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \School\UserBundle\Entity\Task 
     */
    public function getTask()
    {
        return $this->task;
    }
}
