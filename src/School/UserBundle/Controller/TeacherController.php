<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use School\UserBundle\Entity\Lecture;
use School\UserBundle\Form\Type\LectureType;
use School\UserBundle\Entity\CourseClass;
use School\UserBundle\Form\Type\LecturesForCourseType;
use Doctrine\Common\Collections\ArrayCollection;
use School\UserBundle\Entity\Exam;
use School\UserBundle\Entity\Course;
use School\UserBundle\Form\Type\CourseType;
use School\UserBundle\Form\Type\ExamQuestionsType;
use School\UserBundle\Form\Type\QuestionsType;
use School\UserBundle\Entity\ExamQuestion;
use School\UserBundle\Form\Type\AssignedExamType;
use School\UserBundle\Entity\AssignedExam;
use School\UserBundle\Form\Type\ExamType;


/**
* @Security("has_role('ROLE_TEACHER')")
*/
class TeacherController extends Controller
{
    
    public function indexAction(Request $request)
    {
        $teacher = $this->get('security.context')->getToken()->getUser()->getTeacher();
        
        $em = $this->getDoctrine()->getManager();
        
        $courses = $em->getRepository('SchoolUserBundle:Teacher')
            ->findCoursesByTeacher($teacher);
        
        return $this->render('SchoolUserBundle:Teacher:Index.html.twig', array(
            'courses' => $courses,
        ));
    }
    
    /*
    * Add / remove Lectures for a course
    */
    public function addLectureAction($courseId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $course = $em->getRepository('SchoolUserBundle:Course')->find($courseId);

        if (!$course) {
            throw $this->createNotFoundException('No course found for id '.$courseId);
        }
        
        $original_lectures = new ArrayCollection();
        
        foreach ($course->getLectures() as $lecture) {
            $original_lectures->add($lecture);
        }


        $form = $this->createForm(new LecturesForCourseType(), $course);
        $form->handleRequest($request);
        
        if($form->isValid()) {
            foreach($original_lectures as $lecture) {
                if(false === $course->getLectures()->contains($lecture)) {
                    $lecture->setCourse(null);
                    $em->remove($lecture);
                }
            }
            $em->persist($course);
            $em->flush();
            
            return $this->redirect($this->generateUrl('teacher_homepage'));
        } else {       
            return $this->render('SchoolUserBundle:Teacher:AddLecture.html.twig', array(
                'form' => $form->createView(),
                'course' => $course,
            ));
        }
    }
    
    public function listCoursesAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $teacher = $this->get('security.context')->getToken()->getUser()->getTeacher();
        
        $course_classes = $em->getRepository('SchoolUserBundle:CourseClass')->findCoursesByTeacher($teacher);
        
        $grouped = array();
        
        foreach($course_classes as $course_class) {
            $year_name = $course_class->getCourse()->getSchoolYear()->getName();
            if (!isset($grouped[$year_name])) {
               $grouped[$year_name] = array();
            }
            $grouped[$year_name][] = $course_class;
        }
        return $this->render('SchoolUserBundle:Teacher:ListCourses.html.twig', array(
            'course_classes' => $course_classes,
            'grouped' => $grouped,
        ));
        
    }
    
    /**
    * List all exams for a specific course
    */
    public function listExamsAction(Request $request, $course_id, $class_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $exam = new Exam();
        
        $course = $em->getRepository('SchoolUserBundle:Course')->find($course_id);
        $class = $em->getRepository('SchoolUserBundle:SchoolClass')->find($class_id);
        
        $exams = $em->getRepository('SchoolUserBundle:Exam')->findByCourse($course);
        
        $assigned_exams = $em->getRepository('SchoolUserBundle:Exam')->findAssignedExamsByCourseClass($course, $class);
        
        // find the exams that are not assigned to a specific course / class
        $non_assigned_exams = array_udiff($exams, $assigned_exams,
          function ($exam, $assigned_exam) {
            return $exam->getId() - $assigned_exam->getId();
          }
        );
        
        $form = $this->createForm(new ExamType(), $exam, array('non_assigned_exams' => $non_assigned_exams));
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $exam_id = $form->get('name')->getData()->getId();
            return $this->redirect($this->generateUrl('teacher_add_assigned_exam', array('course_id' => $course_id, 'class_id' => $class_id, 'exam_id' => $exam_id)));
        } else {        
            return $this->render('SchoolUserBundle:Teacher:ListExams.html.twig', array(
                'course' => $course,
                'class' => $class,
                'exams' => $exams,
                'form' => $form->createView(),
            ));
        }
    }
    
    /**
    * Assign an exam for a specific course and school class
    */
    public function addAssignedExamAction(Request $request, $course_id, $class_id, $exam_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $assigned_exam = new AssignedExam();
        
        $exam = $em->getRepository('SchoolUserBundle:Exam')->find($exam_id);
        $course = $em->getRepository('SchoolUserBundle:Course')->find($course_id);
        $class = $em->getRepository('SchoolUserBundle:SchoolClass')->find($class_id);
        
        $form = $this->createForm(new AssignedExamType(), $assigned_exam);
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $assigned_exam->setExam($exam);
            $assigned_exam->setSchoolClass($class);
            $em->persist($assigned_exam);
            $em->flush();
            return $this->redirect($this->generateUrl('teacher_list_exams', array('course_id' => $course_id, 'class_id' => $class_id)));
        } else {
            return $this->render('SchoolUserBundle:Teacher:AddAssignedExam.html.twig', array(
                'exam' => $exam,
                'course' => $course,
                'class' => $class,
                'form' => $form->createView(),
            ));
        }
    }
    
    public function editAssignedExamAction(Request $request, $assignedExam_id, $course_id, $class_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $assigned_exam = $em->getRepository('SchoolUserBundle:AssignedExam')->find($assignedExam_id);
        
        $form = $this->createForm(new AssignedExamType(), $assigned_exam);
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em->persist($assigned_exam);
            $em->flush();
            return $this->redirect($this->generateUrl('teacher_list_exams', array('course_id' => $course_id, 'class_id' => $class_id)));
        }
        return $this->render('SchoolUserBundle:Teacher:editAssignedExam.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    /**
    * Add an exam for a course
    */
    public function addExamAction(Request $request, $course_id, $class_id)
    {

        $em = $this->getDoctrine()->getManager();
        
        $exam = new Exam();

        $course = $em->getRepository('SchoolUserBundle:Course')->find($course_id);
                
        $form = $this->createForm(new ExamQuestionsType(), $exam);
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $exam->setCourse($course);
            $em->persist($exam);
            $em->flush();
            
            //when the form is sent the user is redirected to edit existing exam 
            $exam_id = $exam->getId();
            return $this->redirect($this->generateUrl('teacher_list_exams', array('course_id' => $course_id, 'class_id' => $class_id)));
        } else {
            return $this->render('SchoolUserBundle:Teacher:AddExam.html.twig', array(
                'form' => $form->createView(),
                'course' => $course,
            ));
        }
        
    }
    
    /**
    * Edit an existing Exam
    */
    public function editExamAction(Request $request, $exam_id, $class_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $exam = $em->getRepository('SchoolUserBundle:Exam')->find($exam_id);
        
        if(!$exam) {
            throw $this->createNotFoundException('Exam not found');
        }
        
        $original_questions = new ArrayCollection();
        
        foreach ($exam->getExamQuestions() as $question) {
            $original_questions->add($question);
        }
        
        $form = $this->createForm(new ExamQuestionsType(), $exam);
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            foreach($original_questions as $question) {
                if($exam->getExamQuestions()->contains($question) === false) {
                    $question->setExam(null);
                    $em->remove($question);
                }
            }
            $em->persist($exam);
            $em->flush();
            return $this->redirect($this->generateUrl('teacher_list_exams', array('course_id' => $exam->getCourse()->getId(), 'class_id' => $class_id)));
        } else {
            return $this->render('SchoolUserBundle:Teacher:EditExam.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }
    
    /**
    * Remove an exam and its relavent questions
    */
    public function removeExamAction(Request $request, $exam_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $exam = $em->getRepository('SchoolUserBundle:Exam')->find($exam_id);
        
        $form = $this->createFormBuilder($exam)
            ->add('save', 'submit', array('label' => 'Delete Exam'))
            ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $exam->setCourse(null);
            $em->remove($exam);
            $em->flush();
        }
        return $this->render('SchoolUserBundle:Teacher:RemoveExam.html.twig', array(
            'exam' => $exam,
            'form' => $form->createView(),
        ));
    }
    
    /**
    * Lists Students / School Class
    */
    public function loadStudentsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $teacher = $this->get('security.context')->getToken()->getUser()->getTeacher();
        
        $classes = $em->getRepository('SchoolUserBundle:Teacher')->findClassByTeacher($teacher);
        
        
        return $this->render('SchoolUserBundle:Teacher:LoadStudents.html.twig', array(
            'classes' => $classes
        ));
    }
    
    public function studentProfileAction($student_id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $student = $em->getRepository('SchoolUserBundle:Student')->find($student_id);
        
        return $this->render('SchoolUserBundle:Teacher:StudentProfile.html.twig', array(
            'student' => $student,
        ));
    }
}