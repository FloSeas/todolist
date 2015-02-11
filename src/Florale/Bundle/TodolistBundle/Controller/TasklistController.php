<?php

namespace Florale\Bundle\TodolistBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Florale\Bundle\TodolistBundle\Entity\Tasklist;

class TasklistController extends Controller
{
    /**
     * @Route("/", name="tasklist_list")
     */
    public function listAction()
    {
        return $this->render('TodoListBundle:tasklist:list.html.twig');
    }
     /**
     * @Route("/new", name="tasklist_new")
     */
    public function newAction(Request $request)
    {
        return $this->processForm(new TaskList(), $request);
    }
    
     /**
     * @Route("/edit", name="tasklist_edit")
     */
    public function editAction(TaskList $tasklist, Request $request)
    {
        return $this->processForm($tasklist, $request);
    }
    
    protected function processForm(TaskList $tasklist, Request $request)
    {
        $form = $this->createForm('tasklist', $tasklist);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tasklist);
            $em->flush();
            return $this->redirect($this->generateUrl('tasklist_edit', array('id' => $tasklist->getId())));
        }
        return $this->render('TodoListBundle:tasklist:edit.html.twig', array(
            'tasklist' => $tasklist,
            'form'   => $form->createView()
        ));
    }
}
