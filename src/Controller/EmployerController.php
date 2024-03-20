<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employer;
use App\Entity\Adresse;
use App\Form\Type\EmployerType;
use App\Form\Type\AdresseType;
use App\Repository\AdresseRepository;
use App\Repository\EmployerRepository; 
use Symfony\Component\HttpFoundation\Request;

#[Route('/employer', requirements: ["_local" => "en|es|fr"], name: "employer_")]
class EmployerController extends AbstractController
{
    #[Route('/', name: 'app_employer')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $employers = $entityManager->getRepository(Employer::class)->findAll();
        return $this->render('employer/index.html.twig', [
            'controller_name' => 'EmployerController',
            'employers' => $employers,
        ]);
    }

    #[Route("/employer/{id<\d+>}", name: "employer_fiche")]
	public function afficherEmployer(int $id, EntityManagerInterface $entityManager): Response
	{
		$employer = $entityManager->getRepository(Employer::class)->find($id);
		if (!$employer) {
			throw $this->createNotFoundException(
			"Aucun employer avec l'id ". $id
			);
		}
		return $this->render('employer/fiche.html.twig', [
            'employer' => $employer,
        ]);
	}

    #[Route("/ajout", name: "employer_ajout")]
    public function ajoutEmployer(Request $request, EntityManagerInterface $entityManager)
    {
        $employer = new Employer();
        $form = $this->createForm(EmployerType::class, $employer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employer);
            $entityManager->flush();
            return $this->redirectToRoute('employer_employer_succes');
        }
        return $this->render('employer/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/succes', name: 'employer_succes')]
    public function succes(): Response
    {
        return $this->render('employer/succes.html.twig');
    }

    #[Route('/modifier/{id}', name: 'employer_modifier')]
    public function modifierEmployer(int $id, Request $request, EntityManagerInterface $entityManager, EmployerRepository $employerRepository): Response
    {
        $employer = $employerRepository->find($id);
        
        if (!$employer) {
            throw $this->createNotFoundException("Employer non trouvé avec l'identifiant : " . $id);
        }

        $form = $this->createForm(EmployerType::class, $employer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('employer_employer_succes', ['id' => $id]);
        }

        return $this->render('employer/modifier.html.twig', [
            'form' => $form->createView(),
            'employer' => $employer,
        ]);
    }
}