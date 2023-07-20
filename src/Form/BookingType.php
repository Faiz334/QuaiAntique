<?php

namespace App\Form;

use App\Entity\Booking;
use App\Repository\OpeningTimeRepository;
use App\Validator\Constraints\OpeningTimeConstraint;
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
    private $openingTimeRepository;

    public function __construct(Security $security,OpeningTimeRepository $openingTimeRepository)
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
                'widget' => 'single_text', // Utilisez 'single_text' pour afficher un champ de saisie simple
                'html5' => true, // Utilisez l'option HTML5 pour le champ de temps
                'input' => 'datetime', // Utilisez 'datetime' pour obtenir une instance DateTime
                'minutes' => [0, 15, 30, 45], // Spécifiez les valeurs disponibles pour les minutes
                'constraints' => [
                    new Callback([$this, 'validateHeure']),
                ],
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
        // Heures d'ouverture et de fermeture au format "H:i"
        $heureOuverture = "12:00";
        $heureFermeture = "20:00";

        $heureSelectionnee = $heure->format('H:i');
        $heureOuverture = \DateTime::createFromFormat('H:i', $heureOuverture);
        $heureFermeture = \DateTime::createFromFormat('H:i', $heureFermeture);

        if ($heureSelectionnee < $heureOuverture->format('H:i') || $heureSelectionnee > $heureFermeture->format('H:i')) {
            $context->buildViolation('Réservation en dehors des horaires d\'ouverture.')
                ->atPath('heure')
                ->addViolation();
        }
    }


}