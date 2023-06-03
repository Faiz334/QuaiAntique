<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230509144428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1148EB0CB');
        $this->addSql('DROP INDEX IDX_64C19C1148EB0CB ON category');
        $this->addSql('ALTER TABLE category DROP dish_id');
        $this->addSql('ALTER TABLE dish ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dish ADD CONSTRAINT FK_957D8CB8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_957D8CB8BCF5E72D ON dish (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD dish_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1148EB0CB ON category (dish_id)');
        $this->addSql('ALTER TABLE dish DROP FOREIGN KEY FK_957D8CB8BCF5E72D');
        $this->addSql('DROP INDEX IDX_957D8CB8BCF5E72D ON dish');
        $this->addSql('ALTER TABLE dish DROP categorie_id');
    }
}
