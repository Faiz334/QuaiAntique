<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Image;
use App\Repository\ImageRepository;
use App\Repository\OpeningTimeRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(ImageRepository $imageRepository, OpeningTimeRepository $openingTimeRepository): Response
    {
        $images = $imageRepository->findAll();

        $openingTimes = $openingTimeRepository->findAll();
        

        return $this->render('image/index.html.twig', [
            'images' => $images,
            'openingTimes' => $openingTimes,
        ]);
    }
}
