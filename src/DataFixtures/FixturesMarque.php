<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\MarquePage;
use App\Entity\MotsCles;

class FixturesMarque extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $motsClesArray = [
            "technologie",
            "informatique",
            "programmation",
            "développement",
            "internet",
            "sécurité",
            "intelligence artificielle",
            "réseaux sociaux",
            "big data",
            "cloud",
            "cybersécurité",
            "cryptomonnaies",
            "blockchain",
            "IUT",
            "machine learning",
            "data science",
            "web",
            "mobile",
            "jeux vidéo",
            "robotique",
            "virtualisation",
            "5G",
            "URL",
            "commerce électronique",
            "cyberpunk"
        ];

        // Boucle pour créer 25 marque-pages
        for ($i = 0; $i < 25; $i++) {
            $marque_pages = new MarquePage();
            $marque_pages->setUrl("https://www.ldlc.com/fiche/PB00590147.html");
            $marque_pages->setDateDeCreation(new \DateTime());
            $marque_pages->setCommentaire("mon future ordi ?");

            // Sélection aléatoire entre 2 et 5 mots-clés
            $nbMotCle = rand(2, 5);
            $selectMotCle = array_rand($motsClesArray, $nbMotCle);

            foreach ($selectMotCle as $index) {
                $mot_cle = new MotsCles();
                $mot_cle->setMotCle($motsClesArray[$index]);
                $marque_pages->addMotCle($mot_cle);
                $manager->persist($mot_cle);
            }

            $manager->persist($marque_pages);
        }

        $manager->flush();
    }
}



		

		



