<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Commentaire;
use App\Form\AdminCommentaireType;
use App\Repository\CommentaireRepository;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentaireController extends AbstractController
{
    /**
     * @Route("/admin/commentaires/{page}", name="admin_commentaire_index", requirements={"page": "\d+"})
     */
    public function index( CommentaireRepository $ripo, $page = 1, Pagination $pagination)
    {
        $pagination->setEntityClass(Commentaire::class)
            ->setPage($page);
        return $this->render('admin/commentaire/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de modifier un commentaire
     * @param Commentaire $commentaire
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/commentaire/{id}/edit", name="admin_commentaire_edit")
     *
     *
     */
    public function edit(Commentaire $commentaire, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdminCommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($commentaire);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le commentaire a bien été modifier !"
            );
            return $this->redirectToRoute('admin_commentaire_index');
        }
        return $this->render('admin/commentaire/edit.html.twig',[
            'commentaire' => $commentaire,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une annonce
     * @param Annonce $annonce
     * @param ObjectManager $manager
     *
     * @Route("/admin/commentaire/{id}/delete", name="admin_commentaire_delete")
     * @return Response
     */
    public  function delete (Commentaire $commentaire, EntityManagerInterface $manager){
        $manager->remove($commentaire);
        $manager->flush();
        $this->addFlash(
            'success',
            "Le commentaire de <strong>{$commentaire->getAuteur()}</strong> a bien été supprimer !"
        );

        return $this->redirectToRoute("admin_commentaire_index");
    }
}
