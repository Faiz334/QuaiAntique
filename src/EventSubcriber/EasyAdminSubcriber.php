<?php

namespace App\EventSubscriber;

use DateTime;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\OpeningTime;
use App\Entity\Card;
use App\Entity\Category;
use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt'],
        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof User
            || $entity instanceof Image
            || $entity instanceof OpeningTime
            || $entity instanceof Dish
            || $entity instanceof Menu
            || $entity instanceof Card
            || $entity instanceof Category
            || $entity instanceof Booking
        ){
            return;
        }

        $now = new DateTime('now');
        $entity->setCreatedAt($now);

    
    }

    public function setEntityUpdatedAt(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof User
            || $entity instanceof Image
            || $entity instanceof OpeningTime
            || $entity instanceof Dish
            || $entity instanceof Menu
            || $entity instanceof Card
            || $entity instanceof Category
            || $entity instanceof Booking
        ){
            return;
        }

        $now = new DateTime('now');
        $entity->setUpdatedAt($now);
    }
}