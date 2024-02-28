<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Form\Type\LivreType;
use App\Form\Type\AuteurType;
use App\Repository\LivreRepository; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;



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

    #[Route("/ajout", name: "livre_ajout")]
    public function ajoutLivre(Request $request, EntityManagerInterface $entityManager)
    {
        // Création d’un objet Livre vierge
        $livre = new Livre();
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() : pour récupérer les données
            // Les données sont déjà stockées dans la variable d’origine
            // $livre = $form->getData();
            // ... Effectuer le/les traitements(s) à réaliser
            // Par exemple :
            $entityManager->persist($livre);
            $entityManager->flush();
            return $this->redirectToRoute('livre_livre_succes');
        }
        return $this->render('livre/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/succes', name: 'livre_succes')]
    public function succes(): Response
    {
        return $this->render('livre/succes.html.twig');
    }

    #[Route("/auteur/ajout", name: "auteur_ajout")]
    public function ajoutAuteur(Request $request, EntityManagerInterface $entityManager)
    {
        // Création d’un objet Livre vierge
        $auteur = new Auteur();
        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($auteur);
            $entityManager->flush();
            return $this->redirectToRoute('livre_auteur_succes');
        }
        return $this->render('livre/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/auteur/succes', name: 'auteur_succes')]
    public function succesAuteur(): Response
    {
        return $this->render('livre/succes.html.twig');
    }

}
