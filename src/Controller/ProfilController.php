<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilEditType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'profil')]
    public function index(
      User $user
    ): Response
    {
        return $this->render('profil/index.html.twig', compact("user"));
    }

    #[Route('/profil/{id}/edit', name: 'profil_edit')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager, User $user): Response
    {
        $form = $this->createForm(ProfilEditType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $entityManager->flush();
            $this->addFlash('message','Profil mis à jour');
            return $this->redirectToRoute('profil', ["id"=> $user->getId()]);
        }
        return $this->render('profil/editProfil.html.twig', [
            'form'=> $form->createView(),
            'user'=>$user

        ]);
    }
}
