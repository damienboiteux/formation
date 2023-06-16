<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Form\QuestionnaireType;
use App\Repository\QuestionnaireRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/questionnaire')]
class QuestionnaireController extends AbstractController
{
    #[Route('/', name: 'app_questionnaire_index', methods: ['GET'])]
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        return $this->render('questionnaire/index.html.twig', [
            'questionnaires' => $questionnaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_questionnaire_new', methods: ['GET', 'POST'])]
    // #[IsGranted('ROLE_FORMATEUR')]
    public function new(Request $request, QuestionnaireRepository $questionnaireRepository, Security $security): Response
    {

        // $user = $security->getUser();
        // $user = $this->getUser();  // Merci à l'abstractController

        // if($user == null ) {
        //     throw new AccessDeniedException('Vous n\'avez pas accès à cette page');
        // }    
        
        // if(!in_array('ROLE_FORMATEUR', $user->getRoles())) {
        //     throw new AccessDeniedException('Vous n\'avez pas accès à cette page');
        // }

        // if(!$security->isGranted('ROLE_FORMATEUR')) {
        //     throw new AccessDeniedException('Vous n\'avez pas accès à cette page');
        // }

        $this->denyAccessUnlessGranted('ROLE_FORMATEUR', null, 'Vous n\'avez pas accès à cette page');

        
        
        $questionnaire = new Questionnaire();
        $questionnaire->setTitre('Titre du questionnaire');
        $question = new Question();
        $question->setLibelle('Question 1');
        $reponse = new Reponse();
        $reponse->setLibelle('Réponse 1');
        $question->addReponse($reponse);
        $questionnaire->addQuestion($question);
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaireRepository->save($questionnaire, true);

            return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/new.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_questionnaire_show', methods: ['GET'])]
    public function show(Questionnaire $questionnaire): Response
    {
        return $this->render('questionnaire/show.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_questionnaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository, $ip): Response
    {
        dd($ip);
        // $user = $this->getUser();

        // if($user !== $questionnaire->getFormateur()) {
        //     throw new AccessDeniedException('Vous n\'avez pas accès à ce questionnaire');
        // }


        // $security->isGranted('CAN_EDIT', $questionnaire);
        $this->denyAccessUnlessGranted('CAN_EDIT', $questionnaire, 'Vous n\'avez pas accès à ce questionnaire' );




        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaireRepository->save($questionnaire, true);

            return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire/edit.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_questionnaire_delete', methods: ['POST'])]
    public function delete(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionnaire->getId(), $request->request->get('_token'))) {
            $questionnaireRepository->remove($questionnaire, true);
        }

        return $this->redirectToRoute('app_questionnaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
