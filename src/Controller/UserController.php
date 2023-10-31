<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class UserController extends AbstractController
{
    #[Route('/private-listeuser', name: 'app_listeuser')]
    public function listeuser(UserRepository $ur): Response
    {
        $users = $ur->findAll();
        return $this->render('user/listeuser.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/profil', name: 'app_profil')]
    public function profil(): Response
    {
        return $this->render('user/profil.html.twig', [
        ]);
    }
}
