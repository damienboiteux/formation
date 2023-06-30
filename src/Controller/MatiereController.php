<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class MatiereController extends AbstractController
{
    #[Route('/matiere', name: 'app_matiere')]
    public function index(): Response
    {
        return $this->render('matiere/index.html.twig', [
            'controller_name' => 'MatiereController',
        ]);
    }

    #[Route('/matiere/new', name: 'new_matiere')]
    public function new_matiere(Request $request, MatiereRepository $repo): Response
    {
        $matiere = new Matiere();
        $form = $this->createForm(MatiereType::class, $matiere);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // $matiere->setCreatedAt(new \DateTime());
            // $matiere->setUpdatedAt(new \DateTime());

            $repo->save($matiere, true);
            $this->addFlash('success', 'Matière créée avec succès');
            return $this->redirectToRoute('app_matiere');
        }

        return $this->render('matiere/new.html.twig', [
            'form' => $form->createView(),
        ]);
    
    }
}
