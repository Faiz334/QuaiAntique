<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Callback;

class BookingType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser(); // Récupération de l'utilisateur connecté

        $builder
            ->add('nom', null, [
                'data' => $user ? $user->getNom() : null, // Pré-remplissage du champ "nom" avec le nom de l'utilisateur connecté
            ])
            ->add('prenom', null, [
                'data' => $user ? $user->getPrenom() : null, // Pré-remplissage du champ "prenom" avec le prénom de l'utilisateur connecté
            ])
            ->add('personne', null, ["label" => "Nombre de personnes ?",
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 15,
                        'minMessage' => 'Le nombre de personnes doit être d\'au moins {{ limit }}.',
                        'maxMessage' => 'Le nombre de personnes ne peut pas dépasser {{ limit }}.',
                    ]),
                ], ])
            ->add('allergy', TextareaType::class,[
                'label' => 'Allergie à signaler?',
                'required' => false,
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new Callback([$this, 'validateDate']),
                ],
            ])
            ->add('heure', TimeType::class, [
                'label' => 'Choisissez un créneau de réservation',
                'input' => 'datetime',
                'hours' => range(12, 20), // Plage d'heures de 12 à 20
                'minutes' => range(0, 45, 15), // Plage de minutes de 0 à 45 par pas de 15
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }

    public function validateDate($date, ExecutionContextInterface $context)
    {
        $today = new \DateTime();
        if ($date < $today) {
            $context->buildViolation('La date ne peut pas être antérieure à aujourd\'hui.')
                ->atPath('date')
                ->addViolation();
        }
    }

    public function validateHeure($heure, ExecutionContextInterface $context)
    {
        $timeSlots = $this->generateTimeSlots();
        $selectedTime = $heure->format('H:i');

        if (!in_array($selectedTime, $timeSlots)) {
            $context->buildViolation('Heure invalide')
                ->atPath('heure')
                ->addViolation();
        }

        $lastTimeSlot = array_key_last($timeSlots);
        if ($selectedTime === $lastTimeSlot) {
            $context->buildViolation('Aucune réservation n\'est acceptée pour la dernière heure avant la fermeture')
                ->atPath('heure')
                ->addViolation();
        }
    }

}