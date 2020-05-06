<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{page}", name="user_index",  requirements={"page": "\d+"})
     * @IsGranted("ROLE_USER")
     */
    public function index($page = 1, Pagination $pagination)
    {
        $pagination->setEntityClass(User::class)
            ->setPage($page);
        return $this->render('user/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
