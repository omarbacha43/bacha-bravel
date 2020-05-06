<?php

namespace App\Repository;

use App\Entity\Destination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Destination|null find($id, $lockMode = null, $lockVersion = null)
 * @method Destination|null findOneBy(array $criteria, array $orderBy = null)
 * @method Destination[]    findAll()
 * @method Destination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Destination::class);
    }

    public function findSearch($search, $nbRes = null)
    {
        $destination = $search->getDestination();
        $favoris = $search->getFavoris();

        $query = $this->createQueryBuilder('d');

        if ($search->getDestination()){
            $query = $query->andWhere('d.destination = :destination')
                ->setParameter('destination', $search->getDestination());
        }

        if ($search->getFavoris()){
            $query = $query->andWhere('d.favoris = :favoris')
                ->setParameter('favoris', $search->getFavoris());
        }

        if ($nbRes){
            $query->orderBy('d.createdAt', 'DESC');
            $query = $query->setMaxResults($nbRes);
        }

        return $query->getQuery()
            ->getResult();

    }
    // /**
    //  * @return destination[] Returns an array of destination objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?destination
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
