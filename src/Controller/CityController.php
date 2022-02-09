<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Place;
use App\Form\CityType;
use App\Form\PlaceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CityController extends AbstractController
{
    #[Route('/city', name: 'city')]
    public function index(): Response
    {
        return $this->render('city/index.html.twig', [
            'controller_name' => 'CityController',
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

    #[Route('/new_city', name:'new_city')]
    public function newCity(Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = new City();
        $formCity = $this->createForm(CityType::class, $city);
        $formCity->handleRequest($request);

        if ($formCity->isSubmitted() && $formCity->isValid()) {
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('new_place', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('city/new.html.twig', [
            'city' => $city,
            'formCity' => $formCity,
        ]);
    }

}
