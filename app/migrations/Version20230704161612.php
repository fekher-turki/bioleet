<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704161612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE setup (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, cpu VARCHAR(255) DEFAULT NULL, gpu VARCHAR(255) DEFAULT NULL, ram VARCHAR(255) DEFAULT NULL, disk VARCHAR(255) DEFAULT NULL, monitor VARCHAR(255) DEFAULT NULL, mouse VARCHAR(255) DEFAULT NULL, keyboard VARCHAR(255) DEFAULT NULL, mousepad VARCHAR(255) DEFAULT NULL, headphone VARCHAR(255) DEFAULT NULL, microphone VARCHAR(255) DEFAULT NULL, console VARCHAR(255) DEFAULT NULL, controller VARCHAR(255) DEFAULT NULL, INDEX IDX_251D5630A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE setup ADD CONSTRAINT FK_251D5630A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE setup DROP FOREIGN KEY FK_251D5630A76ED395');
        $this->addSql('DROP TABLE setup');
    }
}
