<?php

namespace Florale\Bundle\TodolistBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Florale\Bundle\TodolistBundle\Entity\Tasklist;
use Datatheke\Bundle\PagerBundle\DataGrid\Column\StaticColumn;
use Datatheke\Bundle\PagerBundle\DataGrid\Column\Action\Action;

class TasklistController extends Controller
{
    /**
     * @Route("/", name="tasklist_list")
     */
    public function listAction()
    {
        $translator = $this->get('translator');
        $datagrid = $this->get('datatheke.datagrid')->createHttpDataGrid('TodolistBundle:Tasklist');
        $actions = new StaticColumn('Action');
        $actions->addAction(new Action($translator->trans('tasklist.edit'), 'tasklist_edit', array(
                'icon' => '.icon-edit'
            )),
            'edit'
        );
        $actions->addAction(new Action($translator->trans('task.list'), 'task_list', array(
                'icon' => '.icon-list',
                'item_mapping'  => array('tasklist' => 'id'),
            )),
            'list'
        );
        $actions->addAction(new Action($translator->trans('tasklist.delete'), 'tasklist_delete', array(
                'icon' => '.icon-trash'
            )),
            'delete'
        );
        $datagrid->addColumn($actions, 'delete');
        $view = $datagrid->handleRequest($this->getRequest());

        return $this->render('TodolistBundle:Tasklist:list.html.twig',
                array('datagrid' => $view));
    }
     /**
     * @Route("/new", name="tasklist_new")
     */
    public function newAction(Request $request)
    {
        return $this->processForm(new Tasklist(), $request);
    }
    
    /**
    * @Route("/edit/{id}", name="tasklist_edit")
    */
    public function editAction(TaskList $tasklist, Request $request)
    {
        return $this->processForm($tasklist, $request);
    }
    
    protected function processForm(Tasklist $tasklist, Request $request)
    {
        $form = $this->createForm('tasklist', $tasklist);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tasklist);
            $em->flush();
            return $this->redirect($this->generateUrl('tasklist_list', array('id' => $tasklist->getId())));
        }
        return $this->render('TodolistBundle:Tasklist:edit.html.twig', array(
            'tasklist' => $tasklist,
            'form'   => $form->createView()
        ));
    }
    
    /**
    * @Route("/delete/{id}", name="tasklist_delete")
    */
    public function deleteAction(Tasklist $tasklist)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($tasklist);
        $em->flush();
        $msg = $this->get('translator')->trans('tasklist.message.delete_success');
        $this->get('session')->getFlashBag()->add('success', $msg);
        return $this->redirect($this->generateUrl('tasklist_list'));
    }
}
