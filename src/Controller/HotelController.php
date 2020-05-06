<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class HotelController extends AbstractController
{
    /**
     * @Route("/hotel", name="hotel")
     */
    public function index(HotelRepository $repo)
    {
        $hotels = $repo->findAll();

        return $this->render('hotel/hotel.html.twig', [
            'hotels' => $hotels
        ]);
    }

    /**
     *Permet de creer une hotel
     *
     * @Route("/hotel/new", name="hotel_create")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function create( Request $request, EntityManagerInterface  $manager){

        $hotel = new Hotel();

        $form = $this->createForm(HotelType::class, $hotel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $hotel->setAuteur($this->getUser()->getPrenom()." ".$this->getUser()->getNom())
                ->setCreatedAt(new \DateTime());

            $manager->persist($hotel);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'hotel <strong>{$hotel->getTitre()}</strong> à bein été enregistrée !"
            );
            return $this->redirectToRoute("site_show", ['id' => $hotel->getSite()->getId()]);
        }

        return $this->render('hotel/new.html.twig', [
            'form' => $form->createView()
        ]);;
    }

    /**
     *Permet de modifier un hotel
     *
     * @Route("/hotel/{id}/edit", name="hotel_editor")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function edit(Hotel $hotel, Request $request, EntityManagerInterface  $manager){

        $form = $this->createForm(HotelType::class, $hotel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($hotel);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'hotel <strong>{$hotel->getTitre()}</strong> à bein été enregistrée !"
            );
            return $this->redirectToRoute("site_show", ['id' => $hotel->getSite()->getId()]);
        }

        return $this->render('hotel/edit.html.twig', [
            'form' => $form->createView()
        ]);;
    }

    /**
     * Permet de supprimer un hotel
     *
     * @Route("/hotel/{id}/delete", name="hotel_delete")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public  function delete (Hotel $hotel, EntityManagerInterface $manager){
        $site = $hotel->getSite();
        $manager->remove($hotel);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'hotel a bien été supprimé !"
        );

        return $this->redirectToRoute("site_show", ['id'=>$site->getId()]);
    }

}
