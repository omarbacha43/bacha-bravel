<?php

namespace App\Repository;

use App\Entity\SiteTouristique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SiteTouristique|null find($id, $lockMode = null, $lockVersion = null)
 * @method SiteTouristique|null findOneBy(array $criteria, array $orderBy = null)
 * @method SiteTouristique[]    findAll()
 * @method SiteTouristique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteTouristiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteTouristique::class);
    }

    public function findSearch($search, $nbRes = null)
    {
        $favoris = $search->getFavoris();
        $query = $this->createQueryBuilder('s');

        if ($search->getFavoris()){
            $query = $query->andWhere('s.favoris = :favoris')
                ->setParameter('favoris', $search->getFavoris());
        }
        if ($nbRes){
            $query->orderBy('s.createdAt', 'DESC');
            $query = $query->setMaxResults($nbRes);
        }

        return $query->getQuery()
            ->getResult();

    }
    // /**
    //  * @return SiteTouristique[] Returns an array of SiteTouristique objects
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
    public function findOneBySomeField($value): ?SiteTouristique
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
