<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\User;
use App\Form\BookingType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\OpeningTime;
use App\Repository\OpeningTimeRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BookingController extends AbstractController
{
    #[Route('/reservation', name: 'app_booking')]
    public function index(Request $request, PersistenceManagerRegistry $doctrine, EntityManagerInterface $entityManager, OpeningTimeRepository $openingTimeRepository, SessionInterface $session): Response
    {
        $booking = new Booking();

        // Vérification si l'utilisateur est connecté pour remplir automatiquement les champs nom et prénom
        $user = $this->getUser();
        if ($user) {
            $booking->setNom($user->getNom());
            $booking->setPrenom($user->getPrenom());
        }

        $form = $this->createForm(BookingType::class, $booking );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $existingReservation = $entityManager->getRepository(Booking::class)->findOneBy([
                'date' => $booking->getDate(),
                'heure' => $booking->getHeure(),
            ]);

            if ($existingReservation !== null) {
                $this->addFlash('danger', 'Une réservation existe déjà pour cette date et cette heure.');

            } else {
                // Persistez l'entité Booking dans la base de données
                $em = $doctrine->getManager();
                $em->persist($booking);
                $em->flush();
                
                $this->addFlash('success', 'Votre réservation a bien été enregistrée !');

                return $this->redirectToRoute('app_home');
            }}
        

        return $this->render('booking/booking.html.twig', [
            'form' => $form->createView(),
            'openingTimes' => $openingTimeRepository->findAll(),
        ]);
    }
    /**
     * @Route("/check-reservation", name="check_reservation", methods={"GET"})
     */
    public function checkReservation(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $date = $request->query->get('date');
        $heure = $request->query->get('heure');

        // Effectuer la vérification des réservations existantes
        $existingReservation = $entityManager->getRepository(Booking::class)->findOneBy([
            'date' => new \DateTime($date),
            'heure' => new \DateTime($heure),
        ]);

        $reservationExists = $existingReservation !== null;

        return $this->json(['reservationExists' => $reservationExists]);
    }

}
