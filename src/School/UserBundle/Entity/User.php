<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;


class User implements UserInterface, \Serializable
{
    private $id;
    
    private $username;
    
    private $password;
    
    private $email;
    
    private $isActive;
    
    private $roles;

    
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
    
    public function getRoles()
    {
        return $this->roles->toArray();
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
    /**
     * @var boolean
     */
    private $is_active;


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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set is_active
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get is_active
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->is_active;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $category;


    /**
     * Add category
     *
     * @param \School\UserBundle\Entity\Role $category
     * @return User
     */
    public function addCategory(\School\UserBundle\Entity\Role $category)
    {
        $this->category[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \School\UserBundle\Entity\Role $category
     */
    public function removeCategory(\School\UserBundle\Entity\Role $category)
    {
        $this->category->removeElement($category);
    }

    /**
     * Get category
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add roles
     *
     * @param \School\UserBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\School\UserBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \School\UserBundle\Entity\Role $roles
     */
    public function removeRole(\School\UserBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }
}
