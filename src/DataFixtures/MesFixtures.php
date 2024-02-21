<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Livre;
use App\Entity\Auteur;

class MesFixtures extends Fixture
{
    	public function load(ObjectManager $manager)
	 {
		 for ($i = 0; $i < 15; $i++) {
		 	$auteur = new Auteur();
		    $auteur->setNom('Nom '.$i);
		    $auteur->setPrenom('Prenom '.$i);

			 $livre = new Livre();
			 $livre->setTitre('Livre '.$i);
			 $livre->setAnneeParution(new \DateTime(mt_rand(1975, 2020)));
			 $livre->setNbPage(mt_rand(45, 1500));
			 $manager->persist($livre);
			 $manager->persist($auteur);
		 }
		 }
		 $manager->flush();
	 }
}
