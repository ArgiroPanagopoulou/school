<?php
namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use School\UserBundle\Form\Type\StudentExamType;
use School\UserBundle\Entity\TakenExam;
use School\UserBundle\Entity\TakenQuestion;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\Session;


class StudentController extends Controller
{
    public function studentProfileAction()
    {
        $student = $this->get('security.context')->getToken()->getUser()->getStudent();

        return $this->render('SchoolUserBundle:Student:StudentProfile.html.twig', array(
            'student' => $student,
        ));
    }
    
    public function listCoursesAction($course_id)
    {
        $student = $this->get('security.context')->getToken()->getUser()->getStudent();
        
        $em = $this->getDoctrine()->getManager();

        $school_class = $student->getSchoolClass();
        
        $course = $em->getRepository('SchoolUserBundle:Course')->find($course_id);
        
        $assigned_exams = $em->getRepository('SchoolUserBundle:AssignedExam')->findAssignedExamsByCourseClass($course, $school_class);
        
        $taken_exams = $em->getRepository('SchoolUserBundle:AssignedExam')->findTakenExamsForStudent($student, $school_class, $course );
        
        $not_taken_exams = array_udiff($assigned_exams, $taken_exams, 
            function ( $assigned_exam, $taken_exam) {
                return $assigned_exam->getId() - $taken_exam->getId();
            }
        );
        return $this->render('SchoolUserBundle:Student:ListCourses.html.twig', array(
            'course' => $course,
            'taken_exams' =>$taken_exams,
            'not_taken_exams' => $not_taken_exams,
        ));
    }
    
    /**
    *   Exam taken by a specific student 
    */
    public function examAction(Request $request, $assignedExam_id)
    {
        $em = $this->getDoctrine()->getManager();

        $assigned_exam = $em->getRepository('SchoolUserBundle:AssignedExam')->find($assignedExam_id);
        
        $questions = $assigned_exam->getExam()->getExamQuestions();
        
        $student = $this->get('security.context')->getToken()->getUser()->getStudent();
        
        $duration = $assigned_exam->getDuration();
        $duration_format = sscanf($duration, "%d:%d", $hours, $minutes);
        
        $exam = $assigned_exam->getExam();
        
        $form = $this->createForm(new StudentExamType(), $assigned_exam, array('questions' => $questions));
        
        $form->handleRequest($request);
        
        $taken_exam = new TakenExam();
        $existed_taken_exam = $em->getRepository('SchoolUserBundle:TakenExam')->findTakenByStudentExam($student, $assigned_exam);
        
        $start_time = new \DateTime();
        $end_time = $start_time->add(new \DateInterval('PT' . $hours . 'H'. $minutes. 'M')); // Calculate the datetime of an exam termination according to it's duration
        
        if(!$form->isSubmitted()) {
            if(!$existed_taken_exam) {    
                $taken_exam->setStudent($student);
                $taken_exam->setExam($exam);
                $taken_exam->setAssignedExam($assigned_exam);
                $taken_exam->setStartTime(new \DateTime());
                $taken_exam->setEndTime($end_time);
                $taken_exam->setStatus($taken_exam::STATUS_IN_PROGRESS);
                $em->persist($taken_exam);
                $em->flush();
            }
        } elseif ($form->isValid()) {    
            foreach($questions as $question) {
                $taken_question = new TakenQuestion();
                $taken_question->setTakenExam($existed_taken_exam);
                $answer = $form->get('answers_'.$question->getId())->getData();
                $answers[] = $form->get('answers_'.$question->getId())->getData();
                $taken_question->setAnswer($answer);
                $taken_question->setExamQuestion($question);
      
                $em->persist($taken_question);                               
            } 
            
            $score = $existed_taken_exam->calculateScore($answers, $questions);
            $existed_taken_exam->setScore($score);
            $existed_taken_exam->setStatus($taken_exam::STATUS_COMPLETED);
            
            $em->persist($existed_taken_exam);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your score is: '.$existed_taken_exam->getScore()
            );
            
            return $this->redirect($this->generateUrl('student_list_courses', array('course_id' => $exam->getCourse()->getId())));
        } 

        return $this->render('SchoolUserBundle:Student:Exam.html.twig', array(
            'assigned_exam' => $assigned_exam,
            'form' => $form->createView(),
            'endTime' => $end_time,
            'taken_exam' => $existed_taken_exam,
        ));
    }

}