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
use School\UserBundle\Form\Type\LecturesForCourseClassType;
use Doctrine\Common\Collections\ArrayCollection;
use School\UserBundle\Entity\Exam;
use School\UserBundle\Entity\Course;
use School\UserBundle\Form\Type\CourseType;
use School\UserBundle\Form\Type\ExamQuestionsType;
use School\UserBundle\Form\Type\QuestionsType;
use School\UserBundle\Entity\ExamQuestion;

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
    public function addLectureAction($courseClassId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $courseClass = $em->getRepository('SchoolUserBundle:CourseClass')->find($courseClassId);
        
        if (!$courseClass) {
            throw $this->createNotFoundException('No course found for id '.$courseClassId);
        }
        
        $original_lectures = new ArrayCollection();
        
        foreach ($courseClass->getLectures() as $lecture) {
            $original_lectures->add($lecture);
        }


        $form = $this->createForm(new LecturesForCourseClassType(), $courseClass);
        $form->handleRequest($request);
        
        if($form->isValid()) {
            foreach($original_lectures as $lecture) {
                if(false === $courseClass->getLectures()->contains($lecture)) {
                    $lecture->setCourseClass(null);
                    $em->remove($lecture);
                }
            }
            $em->persist($courseClass);
            $em->flush();
            
            return $this->redirect($this->generateUrl('teacher_homepage'));
        } else {       
            return $this->render('SchoolUserBundle:Teacher:AddLecture.html.twig', array(
                'form' => $form->createView(),
                'course' => $courseClass,
            ));
        }
    }
    
    public function listCoursesAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $teacher = $this->get('security.context')->getToken()->getUser()->getTeacher();
        
        $courses = $em->getRepository('SchoolUserBundle:Course')->loadCoursesByTeacher($teacher);
        
        return $this->render('SchoolUserBundle:Teacher:ListCourses.html.twig', array(
            'courses' => $courses,
        ));
        
    }
    
    /**
    * Add an exam for a course
    */
    public function addExamAction(Request $request, $course_id)
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
            return $this->redirect($this->generateUrl('teacher_edit_exam', array('exam_id' => $exam_id)));
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
    public function editExamAction(Request $request, $exam_id)
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
        }
        return $this->render('SchoolUserBundle:Teacher:EditExam.html.twig', array(
            'form' => $form->createView()
        ));
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
}