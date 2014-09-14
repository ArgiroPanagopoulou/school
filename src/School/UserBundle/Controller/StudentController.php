<?php
namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use School\UserBundle\Form\Type\StudentExamType;
use School\UserBundle\Entity\TakenExam;
use School\UserBundle\Entity\TakenQuestion;
use Doctrine\Common\Collections\ArrayCollection;

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
        $course = $em->getRepository('SchoolUserBundle:Course')->find($course_id);
        
        return $this->render('SchoolUserBundle:Student:ListCourses.html.twig', array(
            'course' => $course,
        ));
    }
    
    public function examAction(Request $request, $exam_id)
    {
        $student = $this->get('security.context')->getToken()->getUser()->getStudent();
        
        $em = $this->getDoctrine()->getManager();
        
        $exam = $em->getRepository('SchoolUserBundle:Exam')->find($exam_id);
        
        $taken_exam = new TakenExam();
        
        $questions = $exam->getExamQuestions();
        
        $form = $this->createForm(new StudentExamType(), $exam, array('questions' => $questions));
        
        $form->handleRequest($request);

        
        if($form->isValid()) {
            $taken_exam->setExam($exam);
            $taken_exam->setStudent($student);
                       
            foreach($questions as $question) {
                $taken_question = new TakenQuestion();
                $taken_question->setTakenExam($taken_exam);
                $answer = $form->get('answers_'.$question->getId())->getData();
                $taken_question->setAnswer($answer);
                $taken_question->setExamQuestion($question);
                $em->persist($taken_question);
                $em->persist($taken_exam);
                $em->flush();
            }           
            return $this->redirect($this->generateUrl('student_list_courses', array('course_id' => $exam->getCourse()->getId())));
        } else {
            return $this->render('SchoolUserBundle:Student:Exam.html.twig', array(
                'exam' => $exam,
                'form' => $form->createView(),
            ));
        }
    }
}