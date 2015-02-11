<?php

namespace Florale\Bundle\TodolistBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Florale\Bundle\TodolistBundle\Entity\Task;

class TaskController extends Controller
{
    /**
     * @Route("/", name="task_list")
     */
    public function showAction()
    {
        return $this->render('Task/list.html.twig');
    }
     /**
     * @Route("/new", name="task_new")
     */
    public function newAction(Request $request)
    {
        return $this->processForm(new Task(), $request);
    }
    
     /**
     * @Route("/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request)
    {
        return $this->processForm($task, $request);
    }
    
    protected function processForm(Task $task, Request $request)
    {
        $form = $this->createForm('task', $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return $this->redirect($this->generateUrl('task_edit', array('id' => $task->getId())));
        }
        return $this->render('TodoListBundle:task:edit.html.twig', array(
            'task' => $task,
            'form'   => $form->createView()
        ));
    }
}
