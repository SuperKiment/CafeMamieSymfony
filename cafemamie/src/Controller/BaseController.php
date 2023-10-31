<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutCafeType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TypeCafe;
use App\Repository\TypeCafeRepository;
use Doctrine\ORM\EntityManagerInterface;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', []);
    }

    #[Route('/ajoutcafe', name: 'app_ajoutcafe')]
    public function ajoutCafe(Request $request, EntityManagerInterface $em): Response
    {
        $typecafe = new TypeCafe();

        $form = $this->createForm(AjoutCafeType::class, $typecafe);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($typecafe);
                $em->flush();
                $this->addFlash('notice', 'Café ajouté !');
                return $this->redirectToRoute('app_ajoutcafe');
            }
        }
        return $this->render('base/ajoutcafe.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/liste-typecafe', name: 'app_liste-typecafe')]
    public function listeTypecafe(TypeCafeRepository $cr): Response
    {
        $typecafes = $cr->findAll();

        return $this->render('base/liste-typecafe.html.twig', [
            'cafes' => $typecafes
        ]);
    }
}
