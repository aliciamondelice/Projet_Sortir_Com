<?php

namespace App\Controller;

use App\Entity\Place;
use App\Entity\State;
use App\Entity\Trip;
use App\Entity\User;
use App\Form\PlaceType;
use App\Form\TripType;
use App\Repository\CityRepository;
use App\Repository\SiteRepository;
use App\Repository\StateRepository;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use DateInterval;
use DateTime;
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

            $state = $formTrip->get('saveAndAdd')->isClicked()
                ? $stateRepository->find(2)
                : $stateRepository->find(1);
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



            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trip/new.html.twig', [
            'trip' => $trip,
            'formTrip' => $formTrip,
            'formPlace' => $formPlace,
            'listeVille' => $listeVille,
        ]);

    }

    #[Route('/{id}', name: 'trip_show', methods: ['GET','POST'])]
    public function show(Trip $trip): Response
    {
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
        ]);
    }
    #[Route('/', name: 'choixloc', methods: ['GET','POST'])]
    public function travel(): Response
    {
        $moyen = filter_input(INPUT_POST, "choix", FILTER_SANITIZE_STRING);
        return $moyen;


    }

    #[Route('/{id}/edit', name: 'trip_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trip $trip, EntityManagerInterface $entityManager, CityRepository $cityRepository, StateRepository $stateRepository): Response
    {
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($trip->getState()->getId() == 1) {
                $enregistrer_et_publier = $form->get('saveAndAdd')->isClicked();
                if ($enregistrer_et_publier == true) {
                    $state = $stateRepository->find(2);
                } else {
                    $state = $stateRepository->find(1);
                }
                $trip->setState($state);
            }

            $entityManager->persist($trip);
            $entityManager->flush();
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trip/edit.html.twig', [
            'trip' => $trip,
            'formTrip' => $form
        ]);
    }

    #[Route('/{id}', name: 'trip_delete', methods: ['POST'])]
    public function delete(Request $request, Trip $trip, EntityManagerInterface $entityManager, StateRepository $stateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trip->getId(), $request->request->get('_token'))) {

            $trip->setReasonCancel($request->request->get('why'));
            $state = $stateRepository->find(5);
            $trip->setState($state);

            $entityManager->persist($trip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/register/{id}', name: 'register_user_trip', methods: ['POST'])]
    public function registerUserTrip(Request $request, Trip $trip, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        /*J'instancie l'utilsateur dont l'id est celui de l'utilsateur connecté*/
        $user = $userRepository->find($this->security->getUser()->getId());

        /*Je l'ajoute dans mon tableau users avec la fonction addUser*/
        $trip->addUser($user);

        $entityManager->persist($trip);
        $entityManager->flush();

        return $this->redirectToRoute( 'trip_show', ["id"=>$trip->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/unsubscribe/{id}', name: 'unsubscribe_user_trip', methods: ['POST'])]
    public function unsubscribeUserTrip(Request $request, Trip $trip, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        /*J'instancie l'utilsateur dont l'id est celui de l'utilsateur connecté*/
        $user = $userRepository->find($this->security->getUser()->getId());

        /*Je l'ajoute dans mon tableau users avec la fonction addUser*/
        $trip->removeUser($user);

        $entityManager->persist($trip);
        $entityManager->flush();
        return $this->redirectToRoute('trip_show', ["id"=>$trip->getId()], Response::HTTP_SEE_OTHER);

    }

    public function updateState($trips, StateRepository $stateRepository, EntityManagerInterface $entityManager)
    {
        foreach($trips as $trip){
            /*Si la date de clôture est inférieure à la date du jour et qu'elle est ouverte, alors elle est fermée*/
            if ($trip->getEndingDate()->format('Y-m-d') < date('Y-m-d') && $trip->getState()->getId() == 2){
                /*J'instancie l'état dont l'id est 4(fermé)*/
                $state = $stateRepository->find(4);
                /*Je définis l'état de trip avec la fonction setstate*/
                $trip->setState($state);

                $entityManager->persist($trip);
                $entityManager->flush();
            }
            $startingDate = new DateTime($trip->getStartingDate()->format('Y-m-d')); // Y-m-d
            $startingDate->add(new DateInterval('P30D'));
            $startingDate = $startingDate->format('Y-m-d');

            if(date('Y-m-d') > $startingDate) {
                /*J'instancie l'état dont l'id est 6(archivée)*/
                $state = $stateRepository->find(6);
                /*Je définis l'état de trip avec la fonction setstate*/
                $trip->setState($state);

                $entityManager->persist($trip);
                $entityManager->flush();
            }
        }
    }
    #[Route('/publish/{id}', name: 'publish_trip', methods: ['POST'])]
    public function publishTrip(Trip $trip, EntityManagerInterface $entityManager, StateRepository $stateRepository): Response
    {
        /*J'instancie l'état dont l'id est 2(ouvert)*/
        $state = $stateRepository->find(2);
        /*Je définis l'état de trip avec la fonction setstate*/
        $trip->setState($state);

        $entityManager->persist($trip);
        $entityManager->flush();
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);

    }

}
