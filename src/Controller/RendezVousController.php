<?php

namespace App\Controller;

use App\Entity\SportActivity;
use App\Entity\Reservation;
use App\Form\ReservationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class RendezVousController extends AbstractController
{
    #[Route("/sport-activities", name: "sport_activities")]
    public function showSportActivities(): Response
    {
        $sportActivities = $this->getDoctrine()->getRepository(SportActivity::class)->findAll();

        return $this->render('rendez_vous/sport_activities.html.twig', [
            'sportActivities' => $sportActivities,
        ]);
    }

    #[Route("/make-reservation/{activityId}", name: "make_reservation")]
    public function makeReservation(Request $request, $activityId, EntityManagerInterface $entityManager): Response
    {
        $sportActivity = $entityManager->getRepository(SportActivity::class)->find($activityId);

        $reservation = new Reservation();
        $reservation->setActivity($sportActivity);

        $form = $this->createForm(ReservationFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation effectuée avec succès.');

            return $this->redirectToRoute('sport_activities');
        }

        return $this->render('rendez_vous/make_reservation.html.twig', [
            'form' => $form->createView(),
            'activity' => $sportActivity,
        ]);
    }

    #[Route("/rendez-vous", name: "rendez_vous")]
    public function showRendezVous(): Response
    {
        $rendezVous = [
            ['date' => '2024-01-10', 'heure' => '10:00', 'activite' => 'Football'],
            ['date' => '2024-01-11', 'heure' => '15:30', 'activite' => 'Basketball'],
            ['date' => '2024-01-12', 'heure' => '14:00', 'activite' => 'Tennis'],
            ['date' => '2024-01-13', 'heure' => '18:00', 'activite' => 'Course à pied'],
            ['date' => '2024-01-14', 'heure' => '12:30', 'activite' => 'Natation'],
            ['date' => '2024-01-15', 'heure' => '17:45', 'activite' => 'Volleyball'],
            ['date' => '2024-01-16', 'heure' => '16:15', 'activite' => 'Escalade'],
        ];

        return $this->render('rendez_vous/rende.html.twig', [
            'message' => 'Les sports que vous pouvez choisir :',
            'rendezVous' => $rendezVous,
        ]);
    }
}
