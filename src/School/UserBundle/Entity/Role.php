<?php
namespace School\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


class Role implements RoleInterface
{
    private $id;

    private $name;
    
    private $role;
    
    private $users;
    
    
    public function __construct()
    {
        $this->users = new ArrayCollection();
        
    }
    
    public function getRole()
    {
        return $this->role;
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
* @return Role
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
* Set role
*
* @param string $role
* @return Role
*/
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
* Add users
*
* @param \School\UserBundle\Entity\User $users
* @return Role
*/
    public function addUser(\School\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
* Remove users
*
* @param \School\UserBundle\Entity\User $users
*/
    public function removeUser(\School\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
* Get users
*
* @return \Doctrine\Common\Collections\Collection
*/
    public function getUsers()
    {
        return $this->users;
    }
    
    /**
* Return the role field.
* @return string
*/
    public function __toString()
    {
        return (string) $this->role;
    }
}
