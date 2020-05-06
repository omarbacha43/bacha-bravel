<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Commentaire;
use App\Entity\Destination;
use App\Form\AdminCommentaireType;
use App\Form\AdminDestinationType;
use App\Repository\CommentaireRepository;
use App\Repository\DestinationRepository;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AdminDestinationController extends AbstractController
{
    /**
     * @Route("/admin/destination/{page}", name="admin_destination_index", requirements={"page": "\d+"})
     */
    public function index( DestinationRepository $ripo, $page = 1, Pagination $pagination)
    {
        $pagination->setEntityClass(Destination::class)
            ->setPage($page);
        return $this->render('admin/destination/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de modifier une destination
     * @param Destination $destination
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/destination/{id}/edit", name="admin_destination_edit")
     *
     *
     */
    public function edit(Destination $destination, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdminDestinationType::class, $destination);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($destination);
            $manager->flush();

            $this->addFlash(
                'success',
                "La destination a bien été modifier !"
            );
            return $this->redirectToRoute('admin_destination_index');
        }
        return $this->render('admin/destination/edit.html.twig',[
            'destination' => $destination,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une destination
     * @param Destination $destination
     *
     * @Route("/admin/destination/{id}/delete", name="admin_destination_delete")
     * @return Response
     */
    public  function delete (Destination $destination, EntityManagerInterface $manager){
        $manager->remove($destination);
        $manager->flush();
        $this->addFlash(
            'success',
            "La destination a bien été supprimer !"
        );

        return $this->redirectToRoute("admin_destination_index");
    }
}
