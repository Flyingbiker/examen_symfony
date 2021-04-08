<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/projects", name="projects_list", methods={"GET"})
     */
    public function list(ProjectRepository $projectRepository): Response
    {

        $projects = $projectRepository->findAll();

        return $this->render('project/list.html.twig', [
            'projects' => $projects
        ]);
    }
    
    /**
     * @Route("/projects/add", name="projects_add", methods={"GET","POST"})
     */
    public function add(Request $request,
        EntityManagerInterface $entityManagerInterface): Response
    {
        $project = new Project();
        $project->setStartedAt(new \DateTime())
            ->setStatus("Nouveau");

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManagerInterface->persist($project);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('projects_list');
        }

        return $this->render('project/add.html.twig', [
            'projectForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/projects/{id<\d+>}", name="projects_detail", methods={"GET","POST"})
     */
    public function detail(int $id, Request $request,
        ProjectRepository $projectRepository, 
        EntityManagerInterface $entityManagerInterface): Response
    {
        
        $project = $projectRepository->find($id);
        $tasks = $project->getTasks();

        if ($request->getMethod() === 'POST') {
            $status = $request->request->get('status');
            
            if ($status === 'terminé') {
                $project->setEndedAt(new \DateTime());
            } else {
                $project->setStatus($status);
            }
            
            $entityManagerInterface->persist($project);
            $entityManagerInterface->flush();
        }
    
        return $this->render('project/detail.html.twig', [
            'project' => $project,
            'tasks' => $tasks
        ]);
    }
}
