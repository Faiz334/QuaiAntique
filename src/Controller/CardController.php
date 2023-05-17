<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Category;
use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OpeningTimeRepository;
use App\Repository\CategoryRepository;

class CardController extends AbstractController
{
    #[Route('/card', name: 'app_card')]
    public function index(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, OpeningTimeRepository $openingTimeRepository): Response
    {
        $categoryRepository = $entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        $menuRepository = $entityManager->getRepository(Menu::class);
        $menus = $menuRepository->findAll();
        $openingTimes = $openingTimeRepository->findAll();


        return $this->render('card/index.html.twig', [
            'controller_name' => 'CardController',
            'openingTimes' => $openingTimes,
            'categories' => $categories,
            'menus' => $menus,
        ]);
    }
}
