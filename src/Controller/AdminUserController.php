<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Commentaire;
use App\Entity\Role;
use App\Entity\User;
use App\Service\Pagination;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user/{page}", name="admin_user_index", requirements={"page": "\d+"})
     */
    public function index($page = 1, Pagination $pagination)
    {
        //pour gere les items active du navbar
        $session = new Session();
        $session->set('active_home', null);
        $session->set('active_annonce', null);
        $session->set('active_reservation', null);
        $session->set('active_commentaire', null);
        $session->set('active_user', 'active');

        $pagination->setEntityClass(User::class)
            ->setPage($page);

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de modifer le role d'un user
     * @param Commentaire $commentaire
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/user/{id}/edit", name="admin_user_edit")
     *
     *
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager){

        $form = $this->createFormBuilder()
            ->add('role', ChoiceType::class, [
                'label' => "Role utulisateur",
                'choices'  => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $newrole = new Role();
            $newrole->setTitle($form['role']->getData());

            $manager->persist($newrole);

            $user->addUserRole($newrole);

            $manager->persist($user);

            $manager->flush();

            $this->addFlash(
                'success',
                "Le role à bien été ajouter pour l'utulisateur !"
            );
            return $this->redirectToRoute('admin_user_index');
        }
        return $this->render('admin/user/edit.html.twig',[
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
    /**
     * Permet de supprimer un user
     *
     * @Route("/admin/user/{id}/delete", name="admin_user_delete")
     * @return Response
     */
    public  function delete (User $user, EntityManagerInterface $manager){

        $manager->remove($user);
        $manager->flush();
        $this->addFlash(
            'success',
            "L'utulisateur <strong>{$user->getPrenom()}  {$user->getNom()}</strong> a bien été supprimé !"
        );

        return $this->redirectToRoute("admin_user_index");
    }

    /**
     * Permet de supprimer un role
     *
     * @Route("/role/{id}/delete", name="role_delete")
     * @return Response
     */
    public  function delete_role (Role $role, EntityManagerInterface $manager){
        $user = $role->getUsers();
        $manager->remove($role);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le role a bien été supprimé !"
        );

        return $this->redirectToRoute("admin_user_edit", ['id' => $user->getId()]);
    }
}
