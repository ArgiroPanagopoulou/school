<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContext;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Task
 */
class Task
{
    /**
     * @var integer
     */
    protected $id;
    
    protected $description;
    
    protected $tags;
    
    
    /**
     * @Assert\Type(type="School\UserBundle\Entity\Category")
     */
    protected $category;
    
    
    public function __construct()
    {
        $this->tags = new ArrayCollection();
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

    
    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add tags
     *
     * @param \School\UserBundle\Entity\Tag $tags
     * @return Task
     */
    public function addTag(\School\UserBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \School\UserBundle\Entity\Tag $tags
     */
    public function removeTag(\School\UserBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }
}
