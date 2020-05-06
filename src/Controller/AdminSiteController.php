<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Hotel;
use App\Entity\SiteTouristique;
use App\Form\AdminCommentaireType;
use App\Form\AdminSiteType;
use App\Repository\CommentaireRepository;
use App\Repository\SiteTouristiqueRepository;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminSiteController extends AbstractController
{
    /**
     * @Route("/admin/site/{page}", name="admin_site_index", requirements={"page": "\d+"})
     */
    public function index( SiteTouristiqueRepository $ripo, $page = 1, Pagination $pagination)
    {
        $pagination->setEntityClass(SiteTouristique::class)
            ->setPage($page);
        return $this->render('admin/site/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de modifier un site
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/site/{id}/edit", name="admin_site_edit")
     *
     *
     */
    public function edit(SiteTouristique $site, Request $request, EntityManagerInterface $manager){

        $form = $this->createForm(AdminSiteType::class, $site);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($site);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le site a bien été modifier !"
            );
            return $this->redirectToRoute('admin_site_index');
        }
        return $this->render('admin/site/edit.html.twig',[
            'site' => $site,
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet de supprimer un site
     * @Route("/admin/site/{id}/delete", name="admin_site_delete")
     * @return Response
     */
    public  function delete (SiteTouristique $site, EntityManagerInterface $manager){
        $destination = $site->getDestination();

        $manager->remove($site);
        $manager->flush();
        $this->addFlash(
            'success',
            "Le site a bien été supprimer !"
        );

        return $this->redirectToRoute("admin_site_index");
    }
}
