<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230626152948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_experience DROP FOREIGN KEY FK_C2FBF65E46E90E27');
        $this->addSql('ALTER TABLE profile_experience DROP FOREIGN KEY FK_C2FBF65ECCFA12B8');
        $this->addSql('DROP TABLE profile_experience');
        $this->addSql('ALTER TABLE experience ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_590C103CCFA12B8 ON experience (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_experience (profile_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_C2FBF65E46E90E27 (experience_id), INDEX IDX_C2FBF65ECCFA12B8 (profile_id), PRIMARY KEY(profile_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profile_experience ADD CONSTRAINT FK_C2FBF65E46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_experience ADD CONSTRAINT FK_C2FBF65ECCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103CCFA12B8');
        $this->addSql('DROP INDEX IDX_590C103CCFA12B8 ON experience');
        $this->addSql('ALTER TABLE experience DROP profile_id');
    }
}
