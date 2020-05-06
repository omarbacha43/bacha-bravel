<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Destination;
use App\Entity\SiteTouristique;
use App\Form\CommentaireType;
use App\Form\SiteType;
use App\Repository\DestinationRepository;
use App\Repository\SiteTouristiqueRepository;
use App\Service\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SiteController extends AbstractController
{
    /**
     * @Route("/site/{page}", name="site_index", requirements={"page": "\d+"})
     */
    public function index(DestinationRepository $repo, $page = 1, Pagination $pagination)
    {
        $destination = $repo->findOneBy(
            ['destination' => 'Djibouti']
        );

        $pagination->setEntityClass(Destination::class, "destination", "Djibouti", "findby")
            ->setPage($page);

        return $this->render('site/site.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     *Permet de creer un site touristique
     *
     * @Route("/site/new", name="site_create")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function create( Request $request, EntityManagerInterface $manager){

        $site = new SiteTouristique();

        $form = $this->createForm(SiteType::class, $site);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $site->setAuteur($this->getUser()->getPrenom()." ".$this->getUser()->getNom())
                ->setCreatedAt(new \DateTime());

            $manager->persist($site);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le site <strong>{$site->getTitre()}</strong> à bein été enregistrée !"
            );
            return $this->redirectToRoute("destination_show", ['id' => $site->getDestination()->getId()]);
        }

        return $this->render('site/new.html.twig', [
            'form' => $form->createView()
        ]);;
    }

    /**
     *Permet de modifier un site
     *
     * @Route("/site/{id}/edit", name="site_editor")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function edit(SiteTouristique $site, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(SiteType::class, $site);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $site->setCreatedAt(new \DateTime());

            $manager->persist($site);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le site <strong>{$site->getTitre()}</strong> à bein été enregistrée !"
            );
            return $this->redirectToRoute("destination_show", ['id' => $site->getDestination()->getId()]);
        }

        return $this->render('site/edit.html.twig', [
            'form' => $form->createView()
        ]);;
    }


    /**
     * @Route("/site/{id}/show", name="site_show")
     */
    public function show($id, SiteTouristiqueRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $site = $repo->find($id);

        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $photo = "/images/persone" .rand(1, 5) .".jpg";
            $commentaire->setCreatedAt(new \DateTime())
                ->setSite($site)
                ->setPhoto($photo)
                ;

            if ($commentaire->getAuteur() == null){
                $commentaire->setAuteur("Anonym");
            }

            $manager->persist($commentaire);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre commentaire à bien été enregistrée !"
            );
            return $this->redirectToRoute("site_show", ['id' => $site->getId()]);
        }

        if ($site != null){
            return $this->render('site/show.html.twig', [
                'site' => $site,
                'form' => $form->createView()
            ]);
        }else
        {
            return $this->redirectToRoute("site_index");
        }
    }

    /**
     * Permet de supprimer un site
     * @Route("/site/{id}/delete", name="site_delete")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public  function delete (SiteTouristique $site, EntityManagerInterface $manager){
        $destination = $site->getDestination();

        $manager->remove($site);
        $manager->flush();
        $this->addFlash(
            'success',
            "Le site a bien été supprimer !"
        );

        return $this->redirectToRoute("destination_show", ['id' =>$destination->getId()]);
    }
}
