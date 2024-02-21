<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Livre;
use App\Entity\Auteur;
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

	public function load(ObjectManager $manager)
	 {
		 for ($i = 0; $i < 15; $i++) {
		 $livre = new Livre();
		 $livre->setTitre('Livre '.$i);
		 $livre->setAnneeParution(mt_rand(1975, 2020));
		 $livre->setNbPage(mt_rand(45, 1500));
		 $manager->persist($livre);
		 }
		 $manager->flush();
	 }
}
