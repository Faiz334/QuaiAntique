<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Booking;
use App\Entity\Card;
use App\Entity\Category;
use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Image;
use App\Entity\OpeningTime;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
       
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(BookingCrudController::class)->generateUrl());
    
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('QuaiAntique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site', 'fa fa-undo', 'app_home');

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Reservation', 'fas fa-person', Booking::class);

        yield MenuItem::linkToCrud('Plats', 'fas fa-cookie-bite', Dish::class);

        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);

        yield MenuItem::linkToCrud('Menu', 'fas fa-utensils', Menu::class);

        yield MenuItem::linkToCrud('Image', 'fas fa-image', Image::class);

        yield MenuItem::linkToCrud('Horaires', 'fas fa-clock', OpeningTime::class);

    
        if ($this->isGranted('ROLE_ADMIN')){

            yield MenuItem::subMenu('Utlisateur', 'fas fa-user',)->setSubItems([
                MenuItem::linkToCrud('Tout les Utlisateurs','fas fa-user', User::class),
                MenuItem::linkToCrud('Ajouter','fas fa-plus', User::class)->setAction(Crud::PAGE_NEW)
        ]);}
    
    }
}
