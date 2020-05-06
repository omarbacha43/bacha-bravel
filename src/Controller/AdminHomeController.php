<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Repository\CommentaireRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use App\Service\StatsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(EntityManagerInterface $manager, StatsService $stats)
    {
        $users = $stats->getUserCount();
        $destinations = $stats->getDestinationCount();
        $sites = $stats->getSiteCount();
        $commentaires = $stats->getCommentaireCount();

        return $this->render('admin/home/index.html.twig', [
            'stats' => compact('users', 'destinations','sites', 'commentaires'),
        ]);
    }
}
