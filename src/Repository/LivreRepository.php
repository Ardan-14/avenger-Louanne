<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }
   
    public function FindAuteurByNbLivre($nbLivre): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT a, count(l) AS NbLivres
            FROM App\Entity\Auteur a 
            JOIN a.livres l 
            GROUP BY a.id
            HAVING NbLivres > :nbLivre'
        )->setParameter('nbLivre', $nbLivre);

        return $query->getResult();
    }

    public function getNbLivres()
    {
        $entityManager = $this->getEntityManager();

        $qry = $entityManager->createQuery(
            "select count(l) as nb
            from App\Entity\Livre l"
        );

        return $qry->getResult()[0]["nb"];
    }

    public function getStartBy(string $lettre): array
    {
        $entityManager = $this->getEntityManager();

        $qry = $entityManager->createQuery(
            "select l
            from App\Entity\Livre l
            where l.titre like :lettre
            order by l.titre"
        )->setParameter("lettre", $lettre."%");

        return $qry->getResult();
    }
}
