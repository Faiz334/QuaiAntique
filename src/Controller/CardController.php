<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OpeningTimeRepository;

class CardController extends AbstractController
{
    #[Route('/card', name: 'app_card')]
    public function index(OpeningTimeRepository $openingTimeRepository): Response
    {
        $openingTimes = $openingTimeRepository->findAll();

        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
            'openingTimes' => $openingTimes,
        ]);
    }
}
