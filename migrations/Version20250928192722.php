<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250928192722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
    }
}
