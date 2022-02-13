<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Repository\SiteRepository;
use App\Repository\StateRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(SiteRepository $siteRepository, TripRepository $tripRepository, StateRepository  $stateRepository, TripController $tripController, EntityManagerInterface $entityManager): Response
    {
        $sites = $siteRepository->findAll();
        $trip = $tripRepository->findAll();
        $tripController->updateState($trip,$stateRepository, $entityManager);
        return $this->render('home/index.html.twig', [
            'trips' => $trip,
            'sites' => $sites
        ]);
    }
}
