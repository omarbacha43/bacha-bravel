<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Destination;
use App\Form\AlbumeType;
use App\Form\DestinationType;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class AlbumController extends AbstractController
{
    /**
     * @Route("/album", name="album")
     */
    public function index( AlbumRepository $repo)
    {
        $albums = $repo->findAll();
        return $this->render('album/index.html.twig', [
            'albums' => $albums,
        ]);
    }

    /**
     *Permet de creer une photo dans l'album
     * @Route("/album/new", name="album_create")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function create( Request $request, EntityManagerInterface  $manager){

        $album = new Album();

        $form = $this->createForm(AlbumeType::class, $album);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $album->setCreatedAt(new \DateTime());

            $manager->persist($album);
            $manager->flush();

            $this->addFlash(
                'success',
                "La photo à bien été enregistrée !"
            );
            return $this->redirectToRoute("homepage");
        }

        return $this->render('album/new.html.twig', [
            'form' => $form->createView()
        ]);;
    }
}
