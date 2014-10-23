<?php
namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use School\UserBundle\Entity\Teacher;
use School\UserBundle\Entity\Student;
use School\UserBundle\Form\Type\UserType;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use School\UserBundle\Form\Model\ChangePassword;
use School\UserBundle\Form\Type\ChangePasswordType;

/**
* @Security("is_granted('IS_AUTHENTICATED_FULLY')")
*/
class UserProfileController extends Controller
{
    public function myProfileAction()
    {
        $logged_in_user = $this->get('security.context')->getToken()->getUser();
        
        return $this->render('SchoolUserBundle:UserProfile:UserProfile.html.twig', array(
            'logged_in_user' => $logged_in_user,
        ));
    }
    
    /**
    * Change user's password
    */
    public function changePasswordAction(Request $request)
    {
        // logged in user
        $user = $this->get('security.context')->getToken()->getUser();
        
        $em = $this->getDoctrine()->getManager();
        
        $change_password = new ChangePassword();
        $form = $this->createForm(new ChangePasswordType(), $change_password);
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $pass = $form['newPassword']->getData();
            // encode new password
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($pass, $user->getSalt());
            $user->setPassword($password);
            
            $em->persist($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Password changed successfully!'
            );
            
            return $this->redirect($this->generateUrl('user_profile'));
        } else {
            return $this->render('SchoolUserBundle:UserProfile:ChangePassword.html.twig', array(
                'form' => $form->createView(),
            ));
        }
    }
    
     //TODO rewrite the method 
    public function editUserAction($userId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('SchoolUserBundle:User')
            ->loadUserById($userId);
        
        // Non admin users cannot have access to other users editing page
        $logged_in_user = $this->get('security.context')->getToken()->getUser()->getId();
        if(($logged_in_user != $userId) && (!($this->get('security.context')->isGranted('ROLE_ADMIN')))) {
            throw new AccessDeniedException('You cannot access this page');
        }

        $teacher = new Teacher();
        $teacher->setUser($user);
        
        $student = new Student();
        $student->setUser($user);
        
        // Form UserType is declared as service
        $form = $this->createForm($this->get('form.type.user'), $user); 
        
        $original_role = $user->getRole(); //object
        
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
        // email to be sent to the user when administrator activates the account       
        $email = \Swift_Message::newInstance()
            ->setSubject('Activation Completed')
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    'SchoolUserBundle:Login:email.txt.twig',
                    array('user' => $user)
                )
            );

        $form->handleRequest($request);
        
        if ($form->isValid()) { 
            if($this->get('security.context')->getToken()->getUser()->getRole() == 'ROLE_ADMIN')  {
                $role = $form->get('role')->getData()->getRole();
                
                //Update Teacher / Student DB tables accordingly
                if ( $role == 'ROLE_TEACHER' && !$teacher_exists ) {
                    $em->persist($teacher);
                    $this->get('mailer')->send($email);
                    if ( $student_exists ) {
                        $em->remove($student_exists);
                    }         
                } else if ($role == 'ROLE_STUDENT' && !$student_exists) {
                    $em->persist($student);
                    $this->get('mailer')->send($email);
                    if ( $teacher_exists ) {
                        $em->remove($teacher_exists);
                    }
                } else if ( $role == 'ROLE_ADMIN' && $student_exists ) {
                    $em->remove($student_exists);
                } else if ( $role == 'ROLE_ADMIN' && $teacher_exists ) {
                    $em->remove($teacher_exists);
                }                
            }
            
            $em->persist($user); 
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );
            if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('user_profile'));        
            } else {
                return $this->redirect($this->generateUrl('admin_users'));
            }
        } else {
            return $this->render('SchoolUserBundle:Admin:EditUser.html.twig', array(
                'user' => $user,  
                'form' => $form->createView(),)
            );
        }
    }
}