<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\User;
use App\Form\CompetenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class CompetenceController extends AbstractController
{
    /**
     * @Route("/competence/new", name="competence_edit")
     */
    public function edit(Request $request, EntityManagerInterface $manager)
    {
        $competence = new Competence();
        $form = $this->createForm(CompetenceType::class, $competence);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $competence->setAuteur($this->getUser());

            $manager->persist($competence);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compétence a bien été rajouter !  Vous pouvez maintenant y consulter !"
            );

            return $this->redirectToRoute('competence_edit');
        }

        return $this->render('competence/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de supprimer une competence
     *
     * @Route("/competence/{id}/delete", name="competence_delete")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public  function delete (Competence $competence, EntityManagerInterface $manager){

            $manager->remove($competence);
            $manager->flush();

            $this->addFlash(
                'success',
                "La competence a bien été supprimé !"
            );

        return $this->redirectToRoute("competence_edit");
    }
}
