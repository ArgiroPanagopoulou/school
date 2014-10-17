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
        $user = $securityContext->getToken()->getUser();
        
        $menu = $factory->createItem('root');
        
        $menu->addChild('Home', array('route' => 'homepage'));
        // $menu->addChild('News', array('route' => 'news'));
        
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        if($securityContext->isGranted('ROLE_ADMIN')) {          
            $menu->addChild('Users', array('route' => 'admin_users'));   
            $menu->addChild('Teacher Assignment', array('route' => 'admin_assign_teachers'));
            $menu->addChild('Student Assignment', array('route' => 'admin_assign_students'));  
            $menu->addChild('School Classes', array('route' => 'admin_add_schoolyear'));
        } elseif ($securityContext->isGranted('ROLE_TEACHER')) {
            $menu->addChild('Lectures', array('route' => 'teacher_homepage'));
            $menu->addChild('Exams', array('route' => 'teacher_list_courses'));
            $menu->addChild('Students', array('route' => 'teacher_load_students'));

        } elseif ($securityContext->isGranted('ROLE_STUDENT')) {
            $menu->addChild('My Profile', array('route' => 'student_profile'));
            if($user->getStudent()->getSchoolClass()) {   
                $courses = $user->getStudent()->getSchoolClass()->getSchoolYear()->getCourses();
                $menu->addChild('My Courses')
                    ->setAttribute('dropdown', true);
                foreach($courses as $course) {
                    $menu['My Courses']->addChild($course->getName(), array(
                        'route' => 'student_list_courses',
                        'routeParameters' => array('course_id' => $course->getId()),
                    ));
                }
            }
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
            'route' => 'user_edit', 'routeParameters' => array('userId' => $user_id),  // Currently the edit page for the users is only accessible from admin.
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