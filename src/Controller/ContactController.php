<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ContactRepository;

class ContactController extends AbstractController
{
    #[Route('/private-listecontacts', name: 'app_listecontacts')]
    public function listeContacts(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();
        return $this->render('contact/listecontacts.html.twig', [
            'contacts' => $contacts
        ]);
    }
}
