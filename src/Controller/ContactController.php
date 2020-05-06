<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Destination;
use App\Form\ContactType;
use App\Form\DestinationType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ContactController extends AbstractController
{
    /**
     * @Route("/message", name="contact_index")
     * @IsGranted("ROLE_USER")
     */
    public function index(ContactRepository $repo)
    {
        $messages = $repo->findAll();

        return $this->render('contact/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    /**
     *Permet de creeer un contact
     *
     * @Route("/contact", name="contact_create")
     *
     */
    public function create( Request $request, EntityManagerInterface  $manager){

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contact->setCreatedAt(new \DateTime());

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre message à bein été enregistrée !"
            );
            return $this->redirectToRoute("contact_create");
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form->createView()
        ]);;
    }

    /**
     * Permet de supprimer un message
     *
     * @Route("/contact/{id}/delete", name="contact_delete")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public  function delete (Contact $contact, EntityManagerInterface $manager){

        $manager->remove($contact);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le message a bien été supprimé !"
        );

        return $this->redirectToRoute("contact_index");
    }
}
