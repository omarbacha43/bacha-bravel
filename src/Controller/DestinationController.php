<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Entity\DestinationSearch;
use App\Entity\SiteTouristique;
use App\Form\DestinationSearchType;
use App\Form\DestinationType;
use App\Repository\DestinationRepository;
use App\Service\Pagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DestinationController extends AbstractController
{
    /**
     * @Route("/destination/{page}", name="destination_index", requirements={"page": "\d+"})
     */
    public function index(DestinationRepository $repo, Request $request, $page = 1, Pagination $pagination)
    {

        $search = new DestinationSearch();
        $form = $this->createForm(DestinationSearchType::class, $search);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $pagination->setEntityClass(Destination::class, "destination", $search->getDestination(), "findby")
                ->setPage($page);
        } else
        {
            $pagination->setEntityClass(Destination::class)
                ->setPage($page);
        }

        return $this->render('destination/destination.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination
        ]);
    }

    /**
     *Permet de creeer une destination
     *
     * @Route("/destination/new", name="destination_create")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function create( Request $request, EntityManagerInterface  $manager){

        $destination = new Destination();

        $form = $this->createForm(DestinationType::class, $destination);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $destination->setAuteur($this->getUser()->getPrenom()." ".$this->getUser()->getNom())
                ->setCreatedAt(new \DateTime());

            $manager->persist($destination);
            $manager->flush();

            $this->addFlash(
                'success',
                "La destination <strong>{$destination->getDestination()}</strong> à bein été enregistrée !"
            );
            return $this->redirectToRoute("destination_index");
        }

        return $this->render('destination/new.html.twig', [
            'form' => $form->createView()
        ]);;
    }

    /**
     *Permet de modifier une destination
     *
     * @Route("/destination/{id}/edit", name="destination_editor")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function edit(Destination $destination, Request $request, EntityManagerInterface  $manager){

        $form = $this->createForm(DestinationType::class, $destination);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $destination->setCreatedAt(new \DateTime());

            $manager->persist($destination);
            $manager->flush();

            $this->addFlash(
                'success',
                "La destination <strong>{$destination->getDestination()}</strong> à bein été enregistrée !"
            );
            return $this->redirectToRoute("destination_index");
        }

        return $this->render('destination/edit.html.twig', [
            'form' => $form->createView()
        ]);;
    }

    /**
     * @Route("destination/{id}/show", name="destination_show")
     */
    public function show($id, DestinationRepository $repo, Request $request){
        $destination = $repo->find($id);

        if ($destination != null){
            return $this->render('destination/show.html.twig',[
                'destination' => $destination,
            ]);
        }else{
            return $this->redirectToRoute("destination_index");
        }

    }
    /**
     * Permet de supprimer une destination
     *
     * @Route("/destination/{id}/delete", name="destination_delete")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public  function delete (Destination $destination, EntityManagerInterface $manager){

        $manager->remove($destination);
        $manager->flush();

        $this->addFlash(
            'success',
            "La destination a bien été supprimé !"
        );

        return $this->redirectToRoute("destination_index");
    }
}
