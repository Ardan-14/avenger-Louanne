<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\MarquePage;
use App\Entity\MotsCles;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/marque', requirements: ["_local" => "en|es|fr"], name: "marque_page_")]
class MarquePageController extends AbstractController
{
    #[Route('/page', name: 'app_marque_page')]
    public function index(EntityManagerInterface $entityManager): Response
    {
    	$marque_pages = $entityManager->getRepository(MarquePage::class)->findAll();
        return $this->render('marque_page/index.html.twig', [
            'controller_name' => 'MarquePageController',
            'marque_pages' => $marque_pages,
        ]);
	}
	#[Route("/ajouter", name: "marque_ajouter")]
	public function ajouterMarque(EntityManagerInterface $entityManager): Response
	{
		$mots_cles = new MotsCles();
		$mots_cles -> setMotCle("Luidgi Manson ?");

		$marque_pages = new MarquePage();
		$marque_pages->setUrl("https://www.ldlc.com/fiche/PB00590147.html");
		$marque_pages->setDateDeCreation(new \DateTime());
		$marque_pages->setCommentaire("mon future ordi ?");
		$marque_pages->addMotCle($mots_cles);


		$entityManager->persist($marque_pages);
		$entityManager->persist($mots_cles);
		$entityManager->flush();

		return new Response("Marque page sauvegardé avec l'id ". $marque_pages->getId());
	}
	#[Route("/fiche/{id<\d+>}", name: "marque_fiche")]
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
