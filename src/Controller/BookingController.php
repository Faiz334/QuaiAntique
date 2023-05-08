<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/reservation', name: 'app_booking')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
    
    #[Route('/reservation/submit', name: 'app_booking_submit', methods: ['POST'])]
    public function submit(Request $request): Response
    {
        // Récupération des données du formulaire
        $personne = $request->request->get('personne');
        $date = $request->request->get('date');
        $heure = $request->request->get('heure');
        $allergy = $request->request->get('allergy');

        // Vérification de la disponibilité de la réservation
        $bookingsAtSameTime = $this->getDoctrine()->getRepository(Booking::class)->findBy([
            'date' => new \DateTime($date),
            'heure' => $heure,
        ]);
        if (count($bookingsAtSameTime) >= 2) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Désolé, il n\'y a plus de places disponibles pour cette heure.',
            ]);
        }

        // Vérification du nombre de convives
        $maximumPersonne = 15; // Récupérer cette valeur depuis le panel d'administration
        if ($personne > $maximumPersonne) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Le nombre de convives dépasse la limite autorisée.',
            ]);
        }

        // Création et enregistrement de la réservation
        $booking = new Booking();
        $booking->setPersonne($personne);
        $booking->setDate(new \DateTime($date));
        $booking->setHeure($heure);
        $booking->setAllergy($allergy);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();

        // Message de succès
        return new JsonResponse([
            'status' => 'success',
            'message' => 'Votre réservation a été enregistrée.',
        ]);
    }

    #[Route('/reservation/disponibilite', name: 'app_booking_disponibilite', methods: ['POST'])]
    public function disponibilite(Request $request): Response
    {
        $date = $request->request->get('date');
        $heure = $request->request->get('heure');

        // Vérification de la disponibilité de la réservation
        $bookingsAtSameTime = $this->getDoctrine()->getRepository(Booking::class)->findBy([
            'date' => new \DateTime($date),
            'heure' => $heure,
        ]);
        $disponibilite = count($bookingsAtSameTime) < 2;

        return new JsonResponse([
            'status' => 'success',
            'disponibilite' => $disponibilite,
        ]);
    }
}
