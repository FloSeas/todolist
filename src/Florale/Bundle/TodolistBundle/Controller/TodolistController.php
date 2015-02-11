<?php

namespace TodolistBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TodolistController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function showAction()
    {
        return $this->render('default/index.html.twig');
    }
    
     /**
     * @Route("/", name="homepage")
     */
    public function addAction()
    {
        return $this->render('default/index.html.twig');
    }
}
