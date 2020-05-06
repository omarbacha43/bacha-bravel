<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\DestinationSearch;
use App\Entity\SiteSearch;
use App\Repository\AlbumRepository;
use App\Repository\BlogRepository;
use App\Repository\ContactRepository;
use App\Repository\DestinationRepository;
use App\Repository\SiteTouristiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function home(BlogRepository $repBlog,ContactRepository $repo, AlbumRepository $repoAl, DestinationRepository $repDes, SiteTouristiqueRepository $repSite){

        $searchSite = new SiteSearch();
        $searchDestination = new DestinationSearch();
        $searchBlog = new Blog();

        $searchSite->setFavoris(true);
        $searchDestination->setFavoris(true);
        $searchBlog->setFavoris(true);

        $destinations = $repDes->findSearch($searchDestination, 6);
        $sites = $repSite->findSearch($searchSite, 6);
        $blogs = $repBlog->findSearch($searchBlog, 3);

        $messages = $repo->findAll();
        $albums = $repoAl->findAll();

        $session = new Session();

        $session->set('messages', $messages);

        return $this->render('home/home.html.twig',[
            'title' => "Bonjours a tous",
            'albums'=> $albums,
            'sites' => $sites,
            'destinations' => $destinations,
            'blogs' => $blogs

        ]);
    }
}
