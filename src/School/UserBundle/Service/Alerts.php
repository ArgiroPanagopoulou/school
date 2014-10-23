<?php
namespace School\UserBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use School\UserBundle\Entity\User;

class Alerts
{
    protected $manager;
    
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }
    
    public function checkRegistrationAlerts()
    {   
        $registration_users = $this->manager->getRepository('SchoolUserBundle:User')->loadUsersNoRole();
        
        return $registration_users;
    }
}