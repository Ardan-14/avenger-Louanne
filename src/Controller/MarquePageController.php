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
