<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function add(Request $request,
        EntityManagerInterface $entityManagerInterface,
        ProjectRepository $projectRepository): Response
    {
        $task = new Task();

        $idProject = $request->query->get('id');
        $project = new Project();
        $project = $projectRepository->find($idProject);
        $task->setProject($project);

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManagerInterface->persist($task);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('projects_detail', ['id' => $idProject ]);
        }

        return $this->render('task/add.html.twig', [
            'taskForm' => $form->createView(),
            'project' => $project
        ]);
    }
}
