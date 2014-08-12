<?php

namespace School\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use School\UserBundle\Entity\User;
use Knp\Menu\ItemInterface;


class MenuBuilder
{
    private $factory;

    
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }
    
    public function mainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        
        $menu->addChild('Home', array('route' => 'homepage'));
        
        $menu->addChild('Student', array('route' => 'student_area'));
        $menu->addChild('Teacher', array('route' => 'teacher_area'));
        
        
        //admin menu
        $menu->addChild('Admin')
             ->setAttribute('dropdown', true);
            
        $menu['Admin']->addChild('Edit Users', array('route' => 'admin_users'));   
        $menu['Admin']->addChild('Assign Teachers', array('route' => 'admin_assign_teachers'));
        $menu['Admin']->addChild('Assign Students', array('route' => 'admin_assign_students'));       
        
        return $menu;
    }
    
    //TODO inject security context as service in order to move user functionality menu to MenuBuilder
    //Right navbar is currently implemented at base.html.twig
    public function userMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');
        
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        
        $menu->addChild('user', array('uri' => '/', 'label' => 'Back to homepage'));
        
        return $menu;
    }
}