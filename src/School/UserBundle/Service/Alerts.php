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
        $users = $this->manager->getRepository('SchoolUserBundle:User')->loadUsersNoRole();
        
        $number_of_alerts = count($users);
        
        return $number_of_alerts;
    }
}