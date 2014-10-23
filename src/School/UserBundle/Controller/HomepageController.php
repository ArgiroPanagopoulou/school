<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use School\UserBundle\Entity\Teacher;
use School\UserBundle\Entity\Student;
use School\UserBundle\Form\Type\UserType;
use Symfony\Component\Security\Core\SecurityContextInterface;


class HomepageController extends Controller
{
    public function homepageAction()
    {
        return $this->render('SchoolUserBundle:Login:homepage.html.twig');
    }
    
    
}
