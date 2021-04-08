<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/projects/list", name="api_projects_list")
     */
    public function list(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        return $this->json([
            'data' => $projects
            ], 200, [],[
                AbstractNormalizer::ATTRIBUTES => [
                    'id', 
                    'name', 
                    'startedAt',
                    'status',
                    'endedAt'
                ]
        ]);
    }
    
    /**
     * @Route("/api/projects/list/{id<\d+>?1}", name="api_projects_detail")
     */
    public function detail(int $id,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository): Response
    {
        $project = $projectRepository->find($id);
        
        return $this->json([
            'data' => $project
            ], 200, [],[
                AbstractNormalizer::ATTRIBUTES => [
                    'id', 
                    'name', 
                    'startedAt',
                    'status',
                    'endedAt',
                    'tasks' => [
                        'title', 
                        'description'
                    ]
                ]
        ]);
    }

}
