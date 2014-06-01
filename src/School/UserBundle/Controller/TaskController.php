<?php

namespace School\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use School\UserBundle\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use School\UserBundle\Form\Type\TaskType;
use Symfony\Component\HttpFoundation\Response;
use School\UserBundle\Entity\Tag;

class TaskController extends Controller
{
    public function addTaskAction(Request $request)
    {
        $task = new Task();
        
        
        var_dump($task);
        
        $form = $this->createForm(new TaskType(), $task);
        
        $form->get('dueDate')->setData(new \DateTime());
        $form->get('task')->setData('new task');
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em =  $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->persist($task->getCategory());
            $em->flush();
            $task = $form->getData();

            return new Response ('added successfully');
        } else
            
        return $this->render('SchoolUserBundle:Task:task.html.twig', array('form' => $form->createView(),));
    }
    
    public function addTagAction(Request $request)
    {
        $task = new Task();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $tag1 = new Tag();
        $tag1->setName('tag1');
        $task->getTags()->add($tag1);
        $tag2 = new Tag();
        $tag2->setName('tag2');
        $task->getTags()->add($tag2);
        // end dummy code

        $form = $this->createForm(new TaskType(), $task);

        $form->handleRequest($request);
        $tags = $task->getTags();
        
        if ($form->isValid()) {
            // ... maybe do some form processing, like saving the Task and Tag objects
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            
            foreach($tags as $tag)
            {
                $em->persist($tag);
            }
            $em->flush();
            $task = $form->getData();
            return new Response('success');
        } else

        return $this->render('SchoolUserBundle:Task:task.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
}   