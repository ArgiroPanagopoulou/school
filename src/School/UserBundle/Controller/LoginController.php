<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use School\UserBundle\Entity\User;
use School\UserBundle\Entity\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\ExpressionLanguage\Expression;
use School\UserBundle\Form\Type\UserType;
use School\UserBundle\Form\Type\RegistrationUserType;

class LoginController extends Controller
{

    public function indexAction($name)
    {
        return $this->render('SchoolUserBundle:Login:index.html.twig', array('name' => $name));
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
            'SchoolUserBundle:Login:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContextInterface::LAST_USERNAME),
                'error'         => $error,
            )
        );
    }
    
    /**
    * User Registration
    */
    public function registerAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(new RegistrationUserType(), $user);
        
        $form->handleRequest($request);
    
        if ($form->isValid()) { 
            //Get the submitted data
            $pass = $form['password']->getData();
            $registration = $form->getData();
            
            $full_name = $form['firstName']->getData() . ' '. $form['lastName']->getData();
            // Encode the password before inserting it into the database
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($pass, $user->getSalt());
            $user->setPassword($password);
            
            $em->persist($user);  
            $em->flush();
            
            return $this->redirect($this->generateUrl('homepage'));
        } else {
            return $this->render(
                'SchoolUserBundle:Login:register.html.twig', 
                    array('form' => $form->createView(),));
        }           
    }
    
    public function loginSuccessAction()
    {
        // Access to login success page only by authenticated users
        if (false === $this->get('security.context')->isGranted(new Expression('is_fully_authenticated()'))) {
            throw new AccessDeniedException();
        } else
        return $this->render('SchoolUserBundle:Login:login_success.html.twig');
    }

}
