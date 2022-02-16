<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/site')]
class SiteController extends AbstractController
{
    #[Route('/', name: 'site')]
    public function index(SiteRepository $siteRepository): Response
    {
        $siteRep= $siteRepository->findAll();
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'siteRep' => $siteRep,
        ]);
    }

    #[Route('/new', name:'new_site')]

    public function newSite(Request $request, EntityManagerInterface $entityManager): Response
    {
        $site = new Site();
        $formSite = $this->createForm(SiteType::class, $site);
        $formSite->handleRequest($request);

        if ($formSite->isSubmitted() && $formSite->isValid()) {
            $entityManager->persist($site);
            $entityManager->flush();

            return $this->redirectToRoute('site', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site/new.html.twig', [
            'site' => $site,
            'formSite' => $formSite,
        ]);
    }
    #[Route('/deleteSite/{id}', name: 'site_delete')]
    public function delete(Request $request, Site $site, EntityManagerInterface $entityManager): Response
    {
        $this->container->get('security.token_storage')->setToken(null);
        $entityManager->remove($site);
        $entityManager->flush();
        $this->addFlash('success', 'Le site a bien été supprimé !');
        return $this->redirectToRoute('site');
    }

}
