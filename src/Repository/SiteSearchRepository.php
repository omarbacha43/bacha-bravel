<?php

namespace App\Repository;

use App\Entity\SiteSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SiteSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteSearch[]    findAll()
 * @method SiteSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteSearch::class);
    }

    // /**
    //  * @return SiteSearch[] Returns an array of SiteSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SiteSearch
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
