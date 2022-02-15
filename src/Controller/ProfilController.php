<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Form\ProfilEditType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/profil/{id}', name: 'profil')]
    public function index(
      User $user,
    ): Response
    {


            return $this->render('profil/index.html.twig', compact("user"));

    }

    #[Route('/profil/{id}/edit', name: 'profil_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(ProfilEditType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->flush();
            $this->addFlash('message','Profil mis à jour');
            return $this->redirectToRoute('profil', ["id"=> $user->getId()]);
        }
        return $this->render('profil/editProfil.html.twig', [
            'form'=> $form->createView(),
            'user'=>$user

        ]);
    }
    #[Route('deleteUser/{id}', name: 'user_delete')]
    public function delete(Request $request ,User $user, EntityManagerInterface $entityManager): Response
    {
        $this->container->get('security.token_storage')->setToken(null);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'Votre compte a bien été supprimé !');
        return $this->redirectToRoute('home');
    }

}
