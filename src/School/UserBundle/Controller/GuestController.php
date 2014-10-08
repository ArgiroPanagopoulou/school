<?php
namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GuestController extends Controller
{
    public function newsAction()
    {
        return $this->render('SchoolUserBundle:Guest:news.html.twig');
    }
}