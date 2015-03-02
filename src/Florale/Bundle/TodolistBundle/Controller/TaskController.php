<?php

namespace Florale\Bundle\TodolistBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Florale\Bundle\TodolistBundle\Entity\Task;
use Florale\Bundle\TodolistBundle\Entity\Tasklist;
use Datatheke\Bundle\PagerBundle\DataGrid\Column\StaticColumn;
use Datatheke\Bundle\PagerBundle\DataGrid\Column\Action\Action;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Datatheke\Bundle\PagerBundle\Pager\Field;

class TaskController extends Controller
{
    /**
     * @Route("/task/{tasklist}", name="task_list")
     * @ParamConverter("tasklist", class="TodolistBundle:Tasklist")
     */
    public function listAction(TaskList $tasklist)
    {
        $translator = $this->get('translator');
        $qb = $this->getDoctrine()->getRepository('TodolistBundle:Task')->findBy(array('tasklist' => $tasklist));
        $pager = $this->get('datatheke.pager')->createPager($qb);
        $datagrid = $this->get('datatheke.datagrid')->createHttpDataGrid($pager);
        $actions = new StaticColumn('Action');
        /*
        $actions->addAction(new Action($translator->trans('task.edit'), 'task_edit', array(
                'icon'          => '.icon-edit',
                'item_mapping'  => array($tasklist->getId() => 'tasklist'),
            )),
            'edit'
        );
        */
        $actions->addAction(new Action($translator->trans('task.delete'), 'task_delete', array(
                'icon' => '.icon-trash',
                'item_mapping'  => array('task_id' => 'id'),
                'parameters'    => array('id' => $tasklist->getId())
            )),
            'delete'
        );
        
        $datagrid->addColumn($actions, 'delete');
        $view = $datagrid->handleRequest($this->getRequest());
        $view->setParameters(array('tasklist' => $tasklist->getId()));
        return $this->render('TodolistBundle:Task:list.html.twig',
                array('datagrid' => $view, 'tasklist' => $tasklist->getId()));
    }
     /**
     * @Route("/task/{tasklist}/new", name="task_new")
     * @ParamConverter("tasklist", class="TodolistBundle:Tasklist")
     */
    public function newAction(Request $request, TaskList $tasklist)
    {
        $task = new Task();
        $task->setTasklist($tasklist);
        return $this->processForm($task, $request);
    }
    
     /**
     * @Route("/task/edit/{id}", name="task_edit")
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
            return $this->redirect($this->generateUrl('task_list', array('tasklist' => $task->getTasklist()->getId())));
        }
        return $this->render('TodolistBundle:Task:edit.html.twig', array(
            'task' => $task,
            'form'   => $form->createView()
        ));
    }
    
    /**
    * @Route("/task/{tasklist}/delete/{id}", name="task_delete")
    */
    public function deleteAction(Task $task)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        $msg = $this->get('translator')->trans('task.message.delete_success');
        $this->get('session')->getFlashBag()->add('success', $msg);
        return $this->redirect($this->generateUrl('task_list'));
    }
}
