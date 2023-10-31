<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutFichierType;

class FichierController extends AbstractController
{

    #[Route('/profil-ajouter-fichier', name: 'app_ajouterfichier')]
    public function ajouterfichier(): Response
    {
        $form = $this->createForm(AjoutFichierType::class);
        
        return $this->render('fichier/ajouterfichier.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
