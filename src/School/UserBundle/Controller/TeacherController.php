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
        ));}
    }
    
}