<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use School\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\ExpressionLanguage\Expression;


class DefaultController extends Controller
{

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function indexAction($name)
    {
        return $this->render('SchoolUserBundle:Default:index.html.twig', array('name' => $name));
    }
    
   public function loginAction(Request $request)
   {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'SchoolUserBundle:Default:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContextInterface::LAST_USERNAME),
                'error'         => $error,
            )
        );
   }
   
    public function teacherAction()
    {
        return new Response('Teacher Area');
    }
    
    public function studentAction()
    {
        return new Response('Student Area');
    }
    
    
    public function loginSuccessAction()
    {
        // Access to login success page only by authenticated users
        if (false === $this->get('security.context')->isGranted(new Expression('is_fully_authenticated()'))) {
            throw new AccessDeniedException();
        } else
        return $this->render('SchoolUserBundle:Default:login_success.html.twig');
    }
}
