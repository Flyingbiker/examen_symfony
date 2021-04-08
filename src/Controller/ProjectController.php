<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/projects", name="projects_list")
     */
    public function list(ProjectRepository $projectRepository): Response
    {

        $projects = $projectRepository->findAll();

        return $this->render('project/list.html.twig', [
            'projects' => $projects
        ]);
    }
}
