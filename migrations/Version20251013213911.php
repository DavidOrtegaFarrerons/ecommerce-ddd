<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251013213911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "stockItem" (id UUID NOT NULL, sku VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "stockItem".id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE "stockItem"');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
    }
}
