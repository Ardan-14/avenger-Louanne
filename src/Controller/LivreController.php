<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Repository\LivreRepository; 
use Doctrine\ORM\EntityManagerInterface;

#[Route('/livre', requirements: ["_local" => "en|es|fr"], name: "livre_")]
class LivreController extends AbstractController
{
    #[Route('/', name: 'app_livre')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $livres = $entityManager->getRepository(Livre::class)->findAll();
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
            'livres' => $livres,
        ]);
    }

#[Route("/fiche/{id<\d+>}", name: "livre_fiche")]
	public function afficherLivre(int $id, EntityManagerInterface $entityManager): Response
	{
		$livres = $entityManager->getRepository(Livre::class)->find($id);
		if (!$livres) {
			throw $this->createNotFoundException(
			"Aucun livres avec l'id ". $id
			);
		}
		return $this->render('livre/fiche.html.twig', [
            'livres' => $livres,
        ]);
	}

    #[Route("/auteurs/{nb<\d+>}", name: "livre_auteurslivres")]
    public function auteursPlusDeLivres($nb, LivreRepository $livreRepository): Response
    {
        $auteurs = $livreRepository->FindAuteurByNbLivre($nb);
        return $this->render('livre/auteur.html.twig', [
            'auteurs' => $auteurs,
            'nb' => $nb,
        ]);
    }

    #[Route("/compter", name: "livre_compter")]
    public function compter(LivreRepository $livreRepository): Response
    {
        $nbLivres = $livreRepository->getNbLivres();
        return $this->render('livre/livrecompte.html.twig', [
            'nbLivres' => $nbLivres,
        ]);
    }

    #[Route("/titre/{lettre}", name: "livre_titrecommencepar")]
    public function titreCommencePar($lettre, LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->getStartBy($lettre);
        return $this->render('livre/lettre.html.twig', [
            'livres' => $livres,
            'lettre' => $lettre,
        ]);
    }
}
