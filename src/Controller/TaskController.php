<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks/{id<\d+>}", name="tasks_detail", methods={"GET"})
     */
    public function detail(int $id): Response
    {
        
        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
    
    /**
     * @Route("/tasks/add", name="tasks_add", methods={"GET", "POST"})
     */
    public function add(int $id): Response
    {

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
