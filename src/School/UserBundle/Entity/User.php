<?php

namespace School\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\DisabledException;


class User implements AdvancedUserInterface, \Serializable
{
    private $id;
    
    private $username;
    
    private $firstName;
    
    private $lastName;
    
    private $password;
    
    private $email;

    private $birthDate;

    private $occupation;
    
    private $is_active;

    private $role;

    private $teacher;
   
    private $student;

    private $messages;
    
    
    public function __construct()
    {
        // noop
    }
    
    public function getRoles()
    {
        // Force this proxy $role object to be hydrated
        return array($this->role->getRole());
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

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    
    public function getFullName()
    {
        $fullName = $this->lastName. ' '. $this->firstName;
        return $fullName;
    }
    
    /**
     * Set role
     *
     * @param \School\UserBundle\Entity\Role $role
     * @return User
     */
    public function setRole(\School\UserBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \School\UserBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set teacher
     *
     * @param \School\UserBundle\Entity\Teacher $teacher
     * @return User
     */
    public function setTeacher(\School\UserBundle\Entity\Teacher $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \School\UserBundle\Entity\Teacher 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set student
     *
     * @param \School\UserBundle\Entity\Student $student
     * @return User
     */
    public function setStudent(\School\UserBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }
    
    /**
     * Get student
     *
     * @return \School\UserBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }
    

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set occupation
     *
     * @param string $occupation
     * @return User
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation
     *
     * @return string 
     */
    public function getOccupation()
    {
        return $this->occupation;
    }
    
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    // The user account is enabled by the administrator 
    public function isEnabled()
    {
        if($this->role != NULL) {
            return $this->role;
         }
    }


    /**
     * Add messages
     *
     * @param \School\UserBundle\Entity\Message $messages
     * @return User
     */
    public function addMessage(\School\UserBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \School\UserBundle\Entity\Message $messages
     */
    public function removeMessage(\School\UserBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
