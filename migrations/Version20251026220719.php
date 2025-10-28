<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251026220719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart ADD shipping_street VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD shipping_city VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD shipping_postal_code VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart ADD shipping_country VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cart DROP shipping_street');
        $this->addSql('ALTER TABLE cart DROP shipping_city');
        $this->addSql('ALTER TABLE cart DROP shipping_postal_code');
        $this->addSql('ALTER TABLE cart DROP shipping_country');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE "user" ALTER email TYPE VARCHAR(180)');
    }
}
