<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class StatsService {
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }



    public function getUserCount(){
        return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
    }

    public function getDestinationCount(){
        return $this->manager->createQuery('SELECT COUNT(d) FROM App\Entity\Destination d')->getSingleScalarResult();
    }

    public function getSiteCount(){
        return  $this->manager->createQuery('SELECT COUNT(s) FROM App\Entity\SiteTouristique s')->getSingleScalarResult();
    }
    public function getCommentaireCount(){
        return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\Commentaire c')->getSingleScalarResult();
    }
}
