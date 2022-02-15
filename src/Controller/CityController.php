<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Place;
use App\Form\CityType;
use App\Form\PlaceType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/city')]
class CityController extends AbstractController
{
    #[Route('/', name: 'city')]
    public function index(CityRepository $cityRepository): Response
    {

        $city = $cityRepository->findAll();
        return $this->render('city/index.html.twig', [
            'controller_name' => 'CityController',
            'cities'=> $city,
        ]);
    }


    #[Route('/new_place', name:'new_place')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $place = new Place();
        $formPlace = $this->createForm(PlaceType::class, $place);
        $formPlace->handleRequest($request);

        if ($formPlace->isSubmitted() && $formPlace->isValid()) {
            $entityManager->persist($place);
            $entityManager->flush();

            return $this->redirectToRoute('trip_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('place/new.html.twig', [
            'place' => $place,
            'formPlace' => $formPlace,
        ]);
    }

    #[Route('/new', name:'new_city')]
    public function newCity(Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = new City();
        $formCity = $this->createForm(CityType::class, $city);
        $formCity->handleRequest($request);

        if ($formCity->isSubmitted() && $formCity->isValid()) {
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('city', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('city/new.html.twig', [
            'city' => $city,
            'formCity' => $formCity,
        ]);
    }

}
