<?php

namespace TodolistBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TodolistController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function ShowAction()
    {
        return $this->render('default/index.html.twig');
    }
}
