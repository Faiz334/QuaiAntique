<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\OpeningTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OpeningTimeRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(OpeningTimeRepository $openingTimeRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
 {
        $openingTimes = $openingTimeRepository->findAll();

        return $this->render('base/footer.html.twig', [
            'openingTimes' => $openingTimes,
        ]);
    }
}
    
}