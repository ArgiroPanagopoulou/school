<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use School\UserBundle\Entity\User;
use School\UserBundle\Entity\UserRepository;
use School\UserBundle\Entity\Role;
use School\UserBundle\Entity\Teacher;
use School\UserBundle\Entity\Student;
use School\UserBundle\Entity\SchoolYear;
use School\UserBundle\Entity\CourseClass;
use School\UserBundle\Form\Type\SchoolYearType;
use School\UserBundle\Entity\Course;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use School\UserBundle\Form\Type\UserType;
use School\UserBundle\Form\Type\RoleType;
use School\UserBundle\Form\Type\CourseClassType;
use School\UserBundle\Form\Type\CourseType;
use School\UserBundle\Entity\SchoolClass;
use School\UserBundle\Form\Type\SchoolClassType;
use School\UserBundle\Form\Type\TeacherType;
use School\UserBundle\Form\Type\StudentAssignationType;
use School\UserBundle\Form\Type\TeacherAssignationType;
use School\UserBundle\Form\Model\TeacherAssignation;
use School\UserBundle\Form\Type\StudentFilterType;

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
class AdminController extends Controller
{
    public function adminAction()
    {
        return new Response('Administrator Area');
    }
    
    /**
    *   List of users
    **/
    public function listUsersAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('SchoolUserBundle:User')
            ->loadUsers();
            
        //populate the users_view array with the data to be displayed
        foreach($users as $u) {
            $users_view[] = array(
                'id' => $u['id'], 
                'username' => $u['username'], 
                'role' => $u['role'],
                'name' => $u['name'],
            );
        }

        return $this->render('SchoolUserBundle:Admin:ListUsers.html.twig', array(
            'users' => $users, 
            'users_view' => $users_view)
        );
    }
    
    /**
    *   Edit page for individual users
    */
    public function editUserAction($userId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SchoolUserBundle:User')
            ->loadUserById($userId);
        
        $teacher = new Teacher();
        $teacher->setUser($user);
        
        $student = new Student();
        $student->setUser($user);
        
        //$user->role = $roles; //(count($roles) > 0)? $roles[0] : null;
        $form = $this->createForm(new UserType(), $user); 

        $teacher_exists = $this->getDoctrine()
                ->getRepository('SchoolUserBundle:Teacher')
                ->findOneBy(
                    array('user' => $user)
                );
                
        $student_exists = $this->getDoctrine()
                ->getRepository('SchoolUserBundle:Student')
                ->findOneBy(
                    array('user' => $user)
                );
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->persist($user); 
            
            $roles = $form['role']->getData();            
            $role = $roles->getRole();
          
          
            //Update Teacher / Student DB tables accordingly
            if ( $role == 'ROLE_TEACHER' && !$teacher_exists ) {
                $em->persist($teacher); 
                if ( $student_exists ) {
                    $em->remove($student_exists);
                }         
            } else if ($role == 'ROLE_STUDENT' && !$student_exists) {
                $em->persist($student);
                if ( $teacher_exists ) {
                    $em->remove($teacher_exists);
                }
            } else if ( $role == 'ROLE_ADMIN' && $student_exists ) {
                $em->remove($student_exists);
            } else if ( $role == 'ROLE_ADMIN' && $teacher_exists ) {
                $em->remove($teacher_exists);
            }
            
            $em->flush();
            return $this->redirect($this->generateUrl('admin_users'));
        } else
        return $this->render('SchoolUserBundle:Admin:EditUser.html.twig', array(
            'user' => $user,  
            'form' => $form->createView(),)
        );
    }
    
    
    /*
    *   Assign teachers for courses and classes 
    **/
    public function assignTeachersAction(Request $request)
    {       
        $courseclass = new CourseClass();               
        $em = $this->getDoctrine()->getManager();
        
        $courseClasses = $em->getRepository('SchoolUserBundle:CourseClass')
            ->loadCourseClasses();
        
        $model = new TeacherAssignation();
        
        $schoolYear1 = $this->getDoctrine()
            ->getRepository('SchoolUserBundle:SchoolYear')
            ->findOneById(1);
        
        //$model->setSchoolYear($schoolYear1);
        $form = $this->createForm(new TeacherAssignationType(), $model);
        $form->handleRequest($request);           
        
        //TODO After the form validation the table should load the new data inserted into the database
        if ($form->isValid()) {
            $schoolclass = $form['schoolClasses']->getData();
            $schoolcourse = $form['courses']->getData();
            $teacher = $form['teacher']->getData();
            
            $courseclass->setCourse($schoolcourse);
            $courseclass->setClass($schoolclass);
            $courseclass->setTeacher($teacher);
            
            $em->persist($courseclass);
            $em->flush();
        }
                   
        return $this->render('SchoolUserBundle:Admin:AssignTeachers.html.twig',
            array('form' => $form->createView(),
                  'courseClasses' => $courseClasses,
        ));
        
    }
    
    
    public function assignStudentsAction(Request $request)
    {
        $schoolYear1 = $this->getDoctrine()
            ->getRepository('SchoolUserBundle:SchoolYear')
            ->findOneById(2);
        
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('SchoolUserBundle:Student')
            ->findAllOrderedByName();
 
        $student = new Student();

        $form = $this->createForm(new StudentFilterType(), $student);
        
        $form->handleRequest($request);

        $selected_students = $this->get('request')->request->get('select');
        //var_dump($selected_students); 
        if ($form->isValid()) {
            $schoolClass = $form['schoolClass']->getData();
            $assigned = $form['assigned']->getData();
            
            //$student->setSchoolClass($schoolClass);
            
            //Filters the array of students
            if ($schoolClass) {
                $students = $em->getRepository('SchoolUserBundle:Student')
                    ->findAllBySchoolClass($schoolClass);
            } elseif ($assigned) {
                $students = $em->getRepository('SchoolUserBundle:Student')
                    ->findAllByClassAssignation($assigned);
            }             
        }
        
        // $class = new SchoolClass();
        // //$class->setSchoolYear($schoolYear1);
        
        // $form = $this->createForm(new StudentAssignationType(), $class);

        // if ($this->get('request')->request->get('submit')) {                
            // return $this->redirect($this->generateUrl('admin_test_assigned_students', array('user' => 9)));
        // } else {
            return $this->render('SchoolUserBundle:Admin:AssignStudents.html.twig', array(
                'form' => $form->createView(),
                'students' => $students,
            ));
        //}
    }
    
    public function testAssignedStudentsAction()
    {
        return new Response('test assigned students');
    }
}
