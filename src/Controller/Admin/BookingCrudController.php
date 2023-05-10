<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;



class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            
            TextField::new('nom'),
            TextField::new('prenom'),
            IntegerField::new('personne')->setFormTypeOptions([
                'attr' => [
                    'min' => 1,
                    'max' => 15
                ]
            ]),
            DateField::new('date'),
            TimeField::new('heure')->setFormat('HH:mm'),
            TextField::new('allergy'),
        ];
    }
    
}
