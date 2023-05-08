<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $user = new User();

        $user->setEmail('admin@admin.fr');
        $user->setPrenom('Zinedine');
        $user->setNom('Zidane');
        $user->setRoles(['ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($user, 'admin33');
        $user->setPassword($password);

         $manager->persist($user);

        
         $user = new User();

        $user->setEmail('client@client.fr');
        $user->setPrenom('Kylian');
        $user->setNom('Mbappe');
        $user->setRoles(['ROLE_CLIENT']);

        $password = $this->hasher->hashPassword($user, 'user33');
        $user->setPassword($password);

         $manager->persist($user);

        $manager->flush();
    }
}
