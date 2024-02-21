<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Caillou;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/caillou', requirements: ["_local" => "en|es|fr"], name: "caillou_")]
class CaillouController extends AbstractController
{
    #[Route('/', name: 'app_caillou')]
    public function index(EntityManagerInterface $entityManager): Response
    {
    	$cailloux = $entityManager->getRepository(Caillou::class)->findAll();
        return $this->render('caillou/index.html.twig', [
            'controller_name' => 'CaillouController',
            'cailloux' => $cailloux,
        ]);
    }

    #[Route("/flore}", name: "caillou_flore")]
	public function flore(EntityManagerInterface $entityManager): Response
    {
    	$cailloux = $entityManager->getRepository(Caillou::class)->findAll();
        return $this->render('caillou/flore.html.twig', [
            'cailloux' => $cailloux,
        ]);
    }
}