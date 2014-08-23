<?php

namespace School\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Doctrine\Common\Annotations\AnnotationReader;
use School\UserBundle\Controller\AdminController as Admin;

class MenuBuilder extends ContainerAware
{
  
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $securityContext = $this->container->get('security.context');
        $menu = $factory->createItem('root');
        
        $menu->addChild('Home', array('route' => 'homepage'));
        
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        if($securityContext->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Admin')
             ->setAttribute('dropdown', true);            
            $menu['Admin']->addChild('Edit Users', array('route' => 'admin_users'));   
            $menu['Admin']->addChild('Assign Teachers', array('route' => 'admin_assign_teachers'));
            $menu['Admin']->addChild('Assign Students', array('route' => 'admin_assign_students'));                       
        } elseif ($securityContext->isGranted('ROLE_TEACHER')) {
            $menu->addChild('Edit Lectures', array('route' => 'teacher_homepage'));
            $menu->addChild('Courses', array('route' => 'teacher_list_courses'));
        } elseif ($securityContext->isGranted('ROLE_STUDENT')) {
            $menu->addChild('Student', array('route' => 'student_area'));
        }
                      
        return $menu;
    }

    public function userMenu(FactoryInterface $factory, array $options)
    {
        $securityContext = $this->container->get('security.context');
        $user = $securityContext->getToken()->getUser();
        
        $menu = $factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');

        if(is_object($user)) {
        $user_lastname = $user->getLastName();
        $user_firstname = $user->getFirstName();
        $user_role = $user->getRole()->getName();
        $user_id = $user->getId();
        
        $menu->addChild('user', array(
            'route' => 'admin_user_edit', 'routeParameters' => array('userId' => $user_id),  // Currently the edit page for the users is only accessible from admin.
            'label' => 'Logged in as '.$user_lastname.' '.$user_firstname.' '.'('.$user_role.')',
        ));
        $menu->addChild('Logout', array('route' => 'logout'));
        } else {
            $menu->addChild('Login', array('route' => 'login'));
            $menu->addChild('Register', array('route' => 'register'));
        }
        return $menu;
    }
}