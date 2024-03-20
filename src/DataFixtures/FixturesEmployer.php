<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Employer;
use App\Entity\Adresse;

class FixturesEmployer extends Fixture
{
    	public function load(ObjectManager $manager)
	 {
        $paysArray = [
            'France', 'Allemagne', 'Italie', 'Espagne', 'Royaume-Uni',
            'États-Unis', 'Canada', 'Japon', 'Chine', 'Australie'
        ];

        $villeArray = [
            'Paris', 'Berlin', 'Rome', 'Madrid', 'Londres',
            'New York', 'Toronto', 'Tokyo', 'Pékin', 'Sydney'
        ];

        $rueArray = [
            'Rue de la Paix', 'Unter den Linden', 'Via Appia', 'Gran Vía', 'Baker Street',
            'Fifth Avenue', 'Yonge Street', 'Ginza', 'Chang\'an Avenue', 'George Street'
        ];


        for ($i = 0; $i < 15; $i++) {
            $employer = new Employer();
            $employer->setNom('Nom ' . $i);
            $employer->setPrenom('Prenom ' . $i);

            $indexPays = array_rand($paysArray);
            $indexVille = array_rand($villeArray);
            $indexRue = array_rand($rueArray);

            $adresse = new Adresse();
            $adresse->setPays($paysArray[$indexPays]);
            $adresse->setVille($villeArray[$indexVille]);
            $adresse->setRue($rueArray[$indexRue]);

            $employer->setAdresse($adresse);
            $manager->persist($adresse);

            $manager->persist($employer);
        }

        $manager->flush();
	}
}

