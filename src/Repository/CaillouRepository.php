<?php

namespace App\Repository;

use App\Entity\Caillou;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Caillou>
 *
 * @method Caillou|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caillou|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caillou[]    findAll()
 * @method Caillou[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaillouRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caillou::class);
    }

//    /**
//     * @return Caillou[] Returns an array of Caillou objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Caillou
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
