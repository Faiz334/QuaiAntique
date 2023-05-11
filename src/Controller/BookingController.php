<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BookingController extends AbstractController
{
    #[Route('/reservation', name: 'app_booking')]
    public function index(Request $request, PersistenceManagerRegistry $doctrine): Response
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
  
                // Persistez l'entité Booking dans la base de données
                $em = $doctrine->getManager();
                $em->persist($booking);
                $em->flush();

                // Redirigez vers une autre page ou affichez un message de succès
                return $this->redirectToRoute('app_home');
            }
        

        return $this->render('booking/booking.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
