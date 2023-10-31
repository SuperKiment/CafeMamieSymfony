<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', []);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $contact->setDateEnvoi(new \Datetime());
                $em->persist($contact);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé');
                return $this->redirectToRoute('app_contact');
            }
        }
        return $this->render('base/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/private-categories', name: 'app_categories')]
    public function categories(Request $request, EntityManagerInterface $em, CategorieRepository $cr): Response
    {
        $categories = $cr->findAll();
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', 'Categorie envoyée');
                return $this->redirectToRoute('app_categories');
            }
        }
        return $this->render('base/categories.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }

    #[Route('/private-modifier-categorie/{id}', name: 'app_modifier-categorie')]
    public function modifierCategories(Categorie $categorie, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', 'Categorie modifiée');
                return $this->redirectToRoute('app_categories');
            }
        }

        return $this->render('base/modifier-categories.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie
        ]);
    }

    #[Route('/private-modifier-categorie', name: 'app_modifier-categorie')]
    public function modifierCategoriesNoID(): Response
    {
        $this->addFlash('notice', 'Pas de catégorie spécifiée');
        return $this->redirectToRoute('app_categories');
    }

    #[Route('/private-supprimer-categorie/{id}', name: 'app_supprimer-categorie')]
    public function supprimerCategories(Categorie $categorie, EntityManagerInterface $em): Response
    {
        $em->remove($categorie);
        $em->flush();
        $this->addFlash('notice', 'Categorie supprimée');
        return $this->redirectToRoute('app_categories');
    }

    #[Route('/private-supprimer-categorie', name: 'app_supprimer-categorie')]
    public function supprimerCategoriesNoID(): Response
    {
        $this->addFlash('notice', 'Pas de catégorie spécifiée');
        return $this->redirectToRoute('app_categories');
    }

    #[Route('/a-propos', name: 'app_apropos')]
    public function apropos(): Response
    {
        return $this->render('base/apropos.html.twig', []);
    }

    #[Route('/mentions-legales', name: 'app_mentionslegales')]
    public function mentionslegales(): Response
    {
        return $this->render('base/mentionslegales.html.twig', []);
    }

   

}