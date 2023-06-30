<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route(path: '/user', name: 'user_')]
class UserController extends AbstractController
{

/*
    /user                   : liste
    /user/{id}              : afficher un user
    /user/new               : créer un user
    /user/{id}/edit         : modifier un user
    /user/{id}/delete       : supprimer un user
*/

    #[Route(path: '/', name: 'index')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $repo->findAll(),
        ]);
    }

    #[Route(path: '/{id}', name: 'show', requirements: ['id'=> '\d+'])]
    public function show(Request $request, EntityManagerInterface $em): Response
    {

        $user = $em->find(User::class,$request->get('id'));

        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route(path: '/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('user_new'),
            'validation_groups' => ['Default', 'new'],
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur créé avec succès');
        }
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $em->find(User::class, $request->get('id'));
        $form = $this->createForm(UserType::class, $user)->remove('password');
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Utilisateur modifié avec succès');
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, EntityManagerInterface $em) {
        $user = $em->find(User::class,$id);
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Utilisateur supprimé avec succès');
        return $this->redirectToRoute('user_index');
    }
}