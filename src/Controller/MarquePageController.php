<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\MarquePage;
use Doctrine\ORM\EntityManagerInterface;

class MarquePageController extends AbstractController
{
    #[Route('/marque/page', name: 'app_marque_page')]
    public function index(EntityManagerInterface $entityManager): Response
    {
    	$marque_pages = $entityManager->getRepository(MarquePage::class)->findAll();
        return $this->render('marque_page/index.html.twig', [
            'controller_name' => 'MarquePageController',
            'marque_pages' => $marque_pages,
        ]);
	}
	#[Route("/marque/ajouter", name: "marque_ajouter")]
	public function ajouterMarque(EntityManagerInterface $entityManager): Response
	{
		$marque_pages = new MarquePage();
		$marque_pages->setUrl("https://www.ldlc.com/fiche/PB00590147.html");
		$marque_pages->setDateDeCreation(new \DateTime());
		$marque_pages->setCommentaire("mon future ordi ?");

		$entityManager->persist($marque_pages);
		$entityManager->flush();

		return new Response("Marque page sauvegardé avec l'id ". $marque_pages->getId());
	}
	#[Route("/marque/fiche/{id<\d+>}", name: "marque_fiche")]
	public function afficherMarque(int $id, EntityManagerInterface $entityManager): Response
	{
		$marque_pages = $entityManager->getRepository(MarquePage::class)->find($id);
		// Ne pas oublier de verifier que l'objet existe !
		if (!$marque_pages) {
			throw $this->createNotFoundException(
			"Aucun marque page avec l'id ". $id
			);
		}
		return $this->render('marque_page/fiche.html.twig', [
            'marque_pages' => $marque_pages,
        ]);
	}

}
