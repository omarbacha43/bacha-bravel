<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Entity\Hotel;
use App\Entity\SiteTouristique;
use App\Form\AdminHotelType;
use App\Form\AdminSiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHotelController extends AbstractController
{
    /**
     * @Route("/admin/hotel", name="admin_hotel")
     */
    public function index()
    {
        return $this->render('admin_hotel/index.html.twig', [
            'controller_name' => 'AdminHotelController',
        ]);
    }

    /**
     * Permet de modifier un hotel
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/hotel/{id}/edit", name="admin_hotel_edit")
     *
     *
     */
    public function edit(Hotel $hotel, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdminHotelType::class, $hotel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($hotel);
            $manager->flush();

            $this->addFlash(
                'success',
                "l'hotel a bien été modifier !"
            );
            return $this->redirectToRoute('admin_site_edit', ['id' =>$hotel->getSite()->getId()]);
        }
        return $this->render('admin/hotel/edit.html.twig',[
            'hotel' => $hotel,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer un hotel*
     * @Route("/admin/hotel/{id}/delete", name="admin_hotel_delete")
     * @return Response
     */
    public  function delete (Hotel $hotel, EntityManagerInterface $manager){
        $site = $hotel->getSite();
        $manager->remove($hotel);
        $manager->flush();
        $this->addFlash(
            'success',
            "L'hotel a bien été supprimer !"
        );

        return $this->redirectToRoute("admin_site_edit",['id'=>$site->getId()] );
    }
}
