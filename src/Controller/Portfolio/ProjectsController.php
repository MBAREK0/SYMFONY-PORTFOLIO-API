<?php

namespace App\Controller\Portfolio;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Project;
use App\Form\ProjectsType;
use App\Repository\SkillRepository;
use App\Repository\ProjectRepository;

class ProjectsController extends AbstractController
{
    private $entityManager;
    private $skillRepository;
    private $projectRepository;


    public function __construct(EntityManagerInterface $em, SkillRepository $skillRepository, ProjectRepository $projectRepository)
    {
        $this->entityManager = $em;
        $this->skillRepository = $skillRepository;
        $this->projectRepository = $projectRepository;
    }


    /**
     * ? in this Function we can add, see all the projects
     * ? @Route("/projects", name="app_projects")
     * @param Request $request
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/projects', name: 'app_projects')]
    public function index(Request $request): Response
    {
        $Project = new Project();


        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());


        $form = $this->createForm(ProjectsType::class, $Project, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // try {

            $Project->setUser($this->getUser());

            $this->entityManager->persist($Project);
            $this->entityManager->flush();

            $this->addFlash('success', 'Project created successfully!');
            // } catch (\Exception $e) {
            //     $this->addFlash('error', 'Unable to Add Project ');
            // }
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }


        return $this->render('portfolio/projects/index.html.twig', [
            'form'      => $form->createView(),
            'projects'  => $this->projectRepository->findProjectsByUserDesc($this->getUser()),
        ]);
    }

    /**
     * ? in this Function we can edit the projects
     * ? @Route("/projects/{id}/edit", name="app_projects_edit")
     * @param Request $request
     * @param Project $Project
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/projects/{id}/edit', name: 'app_projects_edit')]
    public function edit(Request $request, Project $Project): Response
    {
        if ($Project->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'You are not authorized to edit this Project');

            return $this->redirectToRoute('app_projects');
        }

        $skills = $this->skillRepository->findSkillsByUser($this->getUser()->getId());

        $form = $this->createForm(ProjectsType::class, $Project, [
            'skills' => $skills,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->entityManager->flush();

                $this->addFlash('success', 'Project updated successfully!');

                return $this->redirectToRoute('app_projects');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Unable to Update Project ');

                return $this->redirectToRoute('app_projects');
            }
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash('error', $error->getMessage());
        }

        return $this->render('portfolio/projects/edit.html.twig', [
            'form'    => $form->createView(),
            'project' => $Project,

        ]);
    }

    /**
     * ? in this Function we can delete the projects
     * ? @Route("/projects/{id}/delete", name="app_projects_delete")
     * @param Project $Project
     * @return Response
     */

    #[IsGranted(new Expression('is_granted("ROLE_USER")'))]
    #[Route('/projects/{id}/delete', name: 'app_projects_delete')]

    public function delete(Project $Project = null): Response
    {
        if ($Project === null) {
            $this->addFlash('error', 'Project not found');

            return $this->redirectToRoute('app_projects');
        }

        $this->entityManager->remove($Project);
        $this->entityManager->flush();

        $this->addFlash('success', 'Project deleted successfully!');

        return $this->redirectToRoute('app_projects');
    }
}
