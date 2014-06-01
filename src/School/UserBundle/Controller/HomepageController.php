<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function homepageAction()
    {
        return $this->render('SchoolUserBundle:Default:homepage.html.twig');
    }
}
