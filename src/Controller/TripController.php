<?php

namespace App\Controller;

use App\Entity\Place;
use App\Entity\State;
use App\Entity\Trip;
use App\Form\PlaceType;
use App\Form\TripType;
use App\Repository\CityRepository;
use App\Repository\SiteRepository;
use App\Repository\StateRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/trip')]
class TripController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    #[Route('/', name: 'trip_index', methods: ['GET'])]
    public function index(TripRepository $tripRepository): Response
    {
        return $this->render('trip/index.html.twig', [
            'trips' => $tripRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'trip_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CityRepository $repoCity, CityRepository $cityRepository, SiteRepository $siteRepository, StateRepository $stateRepository, UserRepository $userRepository): Response
    {
        $place = new Place();
        $formPlace = $this->createForm(PlaceType::class, $place);

        $trip = new Trip();
        $formTrip = $this->createForm(TripType::class, $trip);

        $formTrip->handleRequest($request);

        $listeVille = $repoCity->findAll();

        if ($formTrip->isSubmitted() && $formTrip->isValid()) {

            $state = $stateRepository->find(1);
            $trip->setState($state);


            $organizer = $userRepository->find($this->security->getUser()->getId());
            $trip->setOrganizer($organizer);

            $site = $siteRepository->find($this->security->getUser()->getSite()->getId());
            $trip->setSite($site);

            /* Si le champ pour séléctionner un lieu est vide, on créé un nouveau lieu */
            if(empty($request->request->all('trip')['place'])) {
                /* On créé un objet de type Place */
                $lieu = new Place();
                /* On définit toutes les valeurs de Place */
                $lieu->setName($request->request->all('place')['name']);
                $lieu->setStreet($request->request->all('place')['street']);
                $lieu->setLatitude($request->request->all('place')['latitude']);
                $lieu->setLongitude($request->request->all('place')['longitude']);
                /* On récupère City (la ville) pour la relation ManyToOne de Place */
                $city = $cityRepository->find($request->request->all('place')['city']);
                /* On met City dans Place */
                $lieu->setCity($city);

                /* On créé une nouvelle entrée dans la BDD */
                $entityManager->persist($lieu);
                $entityManager->flush();

                /* On donne la nouvelle entrée à Trip */
                $trip->setPlace($lieu);
            }

            $entityManager->persist($trip);
            $entityManager->flush();



            return $this->redirectToRoute('trip_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trip/new.html.twig', [
            'trip' => $trip,
            'formTrip' => $formTrip,
            'formPlace' => $formPlace,
            'listeVille' => $listeVille,
        ]);

    }

    #[Route('/{id}', name: 'trip_show', methods: ['GET'])]
    public function show(Trip $trip): Response
    {
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
        ]);
    }

    #[Route('/{id}/edit', name: 'trip_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trip $trip, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('trip_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trip/edit.html.twig', [
            'trip' => $trip,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'trip_delete', methods: ['POST'])]
    public function delete(Request $request, Trip $trip, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trip->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trip_index', [], Response::HTTP_SEE_OTHER);
    }

}
