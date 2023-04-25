<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Card;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CardTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCardAttributes(): void
    {
        $card = new Card();
        $card->setTitre('Test card');
        $card->setDescription('This is a test card.');
        $card->setPrix(10.99);

        $this->assertSame('Test card', $card->getTitre());
        $this->assertSame('This is a test card.', $card->getDescription());
        $this->assertSame(10.99, $card->getPrix());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}