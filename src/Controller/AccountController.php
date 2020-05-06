<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class AccountController extends AbstractController
{
    /**
     * Permet d'afficher le profil de l'utulisateur conecté
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     */
    public function myAccount()
    {
        return $this->render('account/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * Permet d'afficher et gerer le formulaire de connexion
     * @Route("/login", name="account_login")
     *
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error != null,
            'username' => $username
        ]);
    }

    /**
     *Permet de se deconnecter
     *
     * @Route("/logout", name="account_logout")
     *
     * @return  \Symfony\Component\HttpFoundation\Response
     */
    public function logout(){
        //Rien a faire
    }

    /**
     * Permet d'afficher le formulaire d'inscription
     *
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function regiser(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $password = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été crée !  Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     *
     * @Route("/account/profile", name="account_profile")
     *
     * @IsGranted("ROLE_USER")
     * @return Response
     */

    public function profile(Request $request, EntityManagerInterface $manager){
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){


            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'les donnée du profile ont été bien enregistrée avec succès'
            );
            return $this->redirectToRoute('user_show', ['slug' => $user->getSlug()]);

        }

        return $this->render("account/profile.html.twig", [
            'form' => $form->createView()
        ]);;
    }

    /**
     * Permet de modifier le mot de passe
     *
     * @Route("/account/update-password", name="account_password")
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     */
    public function updatePassword( Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){

        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())){
                $form->get('oldPassword')->addError(new FormError("Le mot de passe tapé ne correspond pas  à votre mot de passe !"));
            }
            else{

                $newPassword = $passwordUpdate->getNewPassword();
                $password = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($password);

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );

                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('account/password.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * Permet d'afficher la liste des reservations faite par l'utulisateur
     *
     * @Route("/account/reservation", name="account_reservation")
     *
     * @Security("is_granted('ROLE_USER')")
     * @return Response
     */
    public function reservation(){
        return $this->render('account/destination.html.twig');
    }

}
