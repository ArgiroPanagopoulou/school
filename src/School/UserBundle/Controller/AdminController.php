<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use School\UserBundle\Entity\User;
use School\UserBundle\Entity\UserRepository;
use School\UserBundle\Entity\Role;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use School\UserBundle\Form\Type\UserType;
use School\UserBundle\Form\Type\RoleType;

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
class AdminController extends Controller
{
    public function adminAction()
    {
        return new Response('Administrator Area');
    }
    

    public function listUsersAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('SchoolUserBundle:User')
            ->loadUsers();
            
        //populate the users_view array with the data to be displayed
        foreach($users as $u) {
            $users_view[] = array('id' => $u->getId(), 'username' => $u->getUsername(), 'roles' => $u->getRoles());
        }
        //var_dump($users_view);
        return $this->render('SchoolUserBundle:Admin:ListUsers.html.twig', array('users' => $users, 'users_view' => $users_view));
    }
    
    /**
    *   Edit page for individual users
    */
    public function editUserAction($userId, Request $request)
    {
         $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SchoolUserBundle:User')
            ->loadUserById($userId);
        $roles = $user->getRoles();
        
        
        //var_dump($user);
        $form = $this->createForm(new UserType(), $user); 
        //var_dump($user);
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($user);
            $em->flush();
            return new Response('success');
        } else
        return $this->render('SchoolUserBundle:Admin:EditUser.html.twig', array('user' => $user, 'roles' =>$roles, 'form' => $form->createView(),) );
    }
    
   
    //TODO auto generate password for user and email his credentials
    public function addUserAction(Request $request)
    {
        $user = new User();
        $em = $this->getDoctrine()->getManager();
        
        
        $form = $this->createForm(new UserType(), $user);
        var_dump($user);
        
        
        if ($form->isValid()) {
            $em->persist($user);
            $em->flush();
            return new Response('success');
        }else
        return $this->render('SchoolUserBundle:Admin:AddUser.html.twig', 
            array('form' => $form->createView(),
        ));
    }
    
    
}
