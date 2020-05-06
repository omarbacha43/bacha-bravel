<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Commentaire;
use App\Entity\Destination;
use App\Entity\DestinationSearch;
use App\Form\BlogType;
use App\Form\CommentaireType;
use App\Form\DestinationSearchType;
use App\Form\DestinationType;
use App\Repository\BlogRepository;
use App\Repository\DestinationRepository;
use App\Repository\SiteTouristiqueRepository;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{page}", name="blog_index", requirements={"page": "\d+"})
     */
    public function index(BlogRepository $repo, Request $request, $page = 1, Pagination $pagination)
    {
        $pagination->setEntityClass(Blog::class)
            ->setPage($page);

        return $this->render('blog/blog.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     *Permet de creeer un blog
     *
     * @Route("/blog/new", name="blog_create")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function create( Request $request, EntityManagerInterface  $manager){

        $blog = new Blog();

        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $blog->setCreatedAt(new \DateTime());

            $manager->persist($blog);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'evenment à bien été enregistrée !"
            );
            return $this->redirectToRoute("blog_index");
        }

        return $this->render('blog/new.html.twig', [
            'form' => $form->createView()
        ]);;
    }
    /**
     *Permet de modifier un evenement
     *
     * @Route("/blog/{id}/edit", name="blog_editor")
     *
     * @IsGranted("ROLE_USER")
     *
     */
    public function edit(Blog $blog, Request $request, EntityManagerInterface  $manager){

        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $blog->setCreatedAt(new \DateTime());

            $manager->persist($blog);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'evenement à bein été enregistrée !"
            );
            return $this->redirectToRoute("blog_index");
        }

        return $this->render('blog/edit.html.twig', [
            'form' => $form->createView()
        ]);;
    }

    /**
     * @Route("/bllog/{id}/show", name="blog_show")
     */
    public function show($id, BlogRepository $repo, Request $request, EntityManagerInterface $manager)
    {
        $blog = $repo->find($id);

        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $photo = "/images/persone" .rand(1, 5) .".jpg";
            $commentaire->setCreatedAt(new \DateTime())
                ->setBlog($blog)
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
            return $this->redirectToRoute("blog_show", ['id' => $blog->getId()]);
        }

        if($blog != null){
            return $this->render('blog/show.html.twig', [
                'blog' => $blog,
                'form' => $form->createView()
            ]);
        }else{
            return $this->redirectToRoute("blog_index");
        }
    }
    /**
     * Permet de supprimer un evenement
     *
     * @Route("/blog/{id}/delete", name="blog_delete")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public  function delete (Blog $blog, EntityManagerInterface $manager){

        $manager->remove($blog);
        $manager->flush();

        $this->addFlash(
            'success',
            "l'evenement a bien été supprimé !"
        );

        return $this->redirectToRoute("blog_index");
    }
}
