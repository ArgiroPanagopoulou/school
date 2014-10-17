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
use School\UserBundle\Entity\Course;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use School\UserBundle\Form\Type\UserType;
use School\UserBundle\Form\Type\RoleType;
use School\UserBundle\Form\Type\CourseClassType;
use School\UserBundle\Form\Type\CourseType;
use School\UserBundle\Entity\SchoolClass;
use School\UserBundle\Form\Type\StudentAssignationType;
use School\UserBundle\Form\Type\TeacherAssignationType;
use School\UserBundle\Form\Model\TeacherAssignation;
use School\UserBundle\Form\Type\StudentFilterType;
use School\UserBundle\Form\Type\StudentRemovalFromClassType;
use School\UserBundle\Form\Type\NewSchoolYearType;
use Doctrine\Common\Collections\ArrayCollection;



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

        $users = $em->getRepository('SchoolUserBundle:User')->loadAllUsers();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $users,
            $this->get('request')->query->get('page', 1),
            10
        );
            
        return $this->render('SchoolUserBundle:Admin:ListUsers.html.twig', array(
            'users' => $users,
            'pagination' => $pagination,
            ));
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
        
        // Pagination
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $courseClasses,
            $this->get('request')->query->get('page', 1), /*page number*/
            3 // limit per page
        );
        
        $model = new TeacherAssignation();
        
        $form = $this->createForm(new TeacherAssignationType(), $model);
        $form->handleRequest($request);           
        
        if ($form->isValid()) {
            $schoolclass = $form['schoolClasses']->getData();
            $schoolcourse = $form['courses']->getData();
            $teacher = $form['teacher']->getData();

            $schoolclass_id = $form['schoolClasses']->getData()->getId();
            $schoolcourse_id = $form['courses']->getData()->getId();

            $courseclass->setCourse($schoolcourse);
            $courseclass->setClass($schoolclass);
            $courseclass->setTeacher($teacher);
            
            $courseclass_exists = $em->getRepository('SchoolUserBundle:CourseClass')
                    ->findCourseClassById($schoolcourse_id, $schoolclass_id);
            
            //Update an existing course/class or create a new record
            if(empty($courseclass_exists)) {
                $em->persist($courseclass);
                $em->flush();
            } else {
                $courseclass_exists->setTeacher($teacher);
                $em->flush();
            } 
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Teacher '.$teacher->getUser()->getUsername(). ' has been assigned to '.$schoolclass->getName()
            );
            return $this->redirect($this->generateUrl('admin_assign_teachers'));
        } else {        
            return $this->render('SchoolUserBundle:Admin:AssignTeachers.html.twig',
                array('form' => $form->createView(),
                      'pagination' => $pagination,
            ));
        }
    }
    
    public function assignStudentsAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('SchoolUserBundle:Student')
            ->findAllOrderedByName();
 
        $student = new Student();

        $form = $this->createForm(new StudentFilterType(), $student);
        
        $form->handleRequest($request);

        $selected_students = $this->get('request')->request->get('select');

        if ($form->isValid()) {
            $schoolClass = $form['schoolClass']->getData();
            $assigned = $form['assigned']->getData();
            
            //Filters the array of students
            if ($schoolClass) {
                $students = $em->getRepository('SchoolUserBundle:Student')
                    ->findAllBySchoolClass($schoolClass);
            } elseif ($assigned) {
                $students = $em->getRepository('SchoolUserBundle:Student')
                    ->findAllByClassAssignation($assigned);
            }  
            
        }
        return $this->render('SchoolUserBundle:Admin:AssignStudents.html.twig', array(
            'form' => $form->createView(),
            'students' => $students,
        ));
    }

    public function studentSelectAction(Request $request)
    {
        $selected_students = $this->get('request')->request->get('select');
        $selected_students = is_array($selected_students)?
            $selected_students : explode(',', $selected_students);
            
        //Clear the selected_students array from empty values
        $selected_students = array_filter($selected_students, function ($val) {
            return !empty($val);
        });
        
        //If no student is chosen then redirect to the student selection page
        if(empty($selected_students)) {
            $this->get('session')->getFlashBag()->add(
                'notice',
                'You have to select at least one student'
            );
            return $this->redirect($this->generateUrl('admin_assign_students'));
        }
        
        $selected_action = $this->get('request')->request->get('studentAction');
        switch ($selected_action) {
            case 'assignment':
                $response = $this->forward('SchoolUserBundle:Admin:studentAssignmentSelection', array(
                    'request' => $request,
                    'selected_students' => $selected_students,  
                    'selected_action' => $selected_action,
                ));
                break;
            case 'removal':
                $response = $this->forward('SchoolUserBundle:Admin:studentRemovalFromClass', array(
                    'request' => $request,
                    'selected_students' => $selected_students,
                    'selected_action' => $selected_action,
                ));
                break;
            default:
                $response = null;
        }      
        return $response;
    }

    // Selected Action: Student Assignment to classes
    public function studentAssignmentSelectionAction(Request $request, $selected_students, $selected_action)
    {
        
        $class = new SchoolClass();
                
        $form = $this->createForm(new StudentAssignationType(), $class, array(
            'selected_students' => $selected_students,
            'selected_action' => $selected_action,
        ));
        
        $students = array();
        $em = $this->getDoctrine()->getManager();

        foreach ($selected_students as $id) {
            $students[] = $em->getRepository('SchoolUserBundle:Student')
                ->findByUserId($id);
        }    
        
        $form->handleRequest($request);
        

        if ($form->isValid()) {
            $school_class = $form['name']->getData();
            
            foreach($students as $student) {
                $student->setSchoolClass($school_class);
                $em->persist($student);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('admin_assign_students'));
        } else {        
            return $this->render('SchoolUserBundle:Admin:StudentAssignmentSelection.html.twig', array(
                'form' => $form->createView(),
                'students' => $students,
            )); 
        }
        
    }
    
    //Selected Action: Remove students from a class
    public function studentRemovalFromClassAction(Request $request, $selected_students, $selected_action)
    {      
        $em = $this->getDoctrine()->getManager();
        $test = new Student();
        $students = array();
        
        foreach ($selected_students as $id) {
            $students[] = $em->getRepository('SchoolUserBundle:Student')
                ->findByUserId($id);
        }
       
        $form = $this->createForm(new StudentRemovalFromClassType(), $test, array(
            'selected_students' => $selected_students,
            'selected_action' => $selected_action,
        ));
        
        $form->handleRequest($request);
            
        if ($form->isValid()) {
            foreach ($students as $student) {
                $student->setSchoolClass(null);
                $em->persist($student);
            }           
            $em->flush();
            return $this->redirect($this->generateUrl('admin_assign_students'));
        } else {       
            return $this->render('SchoolUserBundle:Admin:StudentRemovalSelection.html.twig', array(
                'students' => $students,
                'form' => $form->createView(),
            ));
        }
    }
    
    public function editSchoolYearAction(Request $request, $school_year_id)
    {
        $em = $this->getDoctrine()->getManager();
        $school_class = new SchoolClass();
        
        $school_year = $em->getRepository('SchoolUserBundle:SchoolYear')->find($school_year_id);
        
        if(!$school_year) {
            throw $this->createNotFoundException('No school year found');
        }
        
        $original_school_classes = new ArrayCollection();
        
        foreach($school_year->getSchoolClasses() as $school_class) {
            $original_school_classes->add($school_class);
        }
        $form = $this->createForm(new NewSchoolYearType(), $school_year);
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            foreach($original_school_classes as $school_class) {
                if(false === $school_year->getSchoolClasses()->contains($school_class)) {
                    $school_class->setSchoolYear(null);
                    $em->persist($school_class);
                    $em->remove($school_class);
                }
            }
            $em->persist($school_year);
            $em->flush();
        }
        return $this->render('SchoolUserBundle:Admin:EditSchoolYear.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function addSchoolYearAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $school_year = new SchoolYear();
        
        $existing_school_years = $em->getRepository('SchoolUserBundle:SchoolYear')->findAll();
        $form = $this->createForm(new NewSchoolYearType(), $school_year);
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em->persist($school_year);
            $em->flush();
        }
        return $this->render('SchoolUserBundle:Admin:AddSchoolYear.html.twig', array(
            'form' => $form->createView(),
            'school_years' => $existing_school_years,
        ));
    }   
}


