<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230624121013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, date DATETIME DEFAULT NULL, place VARCHAR(15) DEFAULT NULL, tournament_name VARCHAR(255) NOT NULL, tournament_link VARCHAR(255) DEFAULT NULL, tournament_logo VARCHAR(255) DEFAULT NULL, team_name VARCHAR(100) NOT NULL, team_logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, game_id INT NOT NULL, ingame_name VARCHAR(70) NOT NULL, bio LONGTEXT DEFAULT NULL, montage VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8157AA0FA76ED395 (user_id), INDEX IDX_8157AA0FE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_game_role (profile_id INT NOT NULL, game_role_id INT NOT NULL, INDEX IDX_E30F3DCCFA12B8 (profile_id), INDEX IDX_E30F3D43C15D83 (game_role_id), PRIMARY KEY(profile_id, game_role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_experience (profile_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_C2FBF65ECCFA12B8 (profile_id), INDEX IDX_C2FBF65E46E90E27 (experience_id), PRIMARY KEY(profile_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE profile_game_role ADD CONSTRAINT FK_E30F3DCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_game_role ADD CONSTRAINT FK_E30F3D43C15D83 FOREIGN KEY (game_role_id) REFERENCES game_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_experience ADD CONSTRAINT FK_C2FBF65ECCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_experience ADD CONSTRAINT FK_C2FBF65E46E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE languages languages JSON DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FE48FD905');
        $this->addSql('ALTER TABLE profile_game_role DROP FOREIGN KEY FK_E30F3DCCFA12B8');
        $this->addSql('ALTER TABLE profile_game_role DROP FOREIGN KEY FK_E30F3D43C15D83');
        $this->addSql('ALTER TABLE profile_experience DROP FOREIGN KEY FK_C2FBF65ECCFA12B8');
        $this->addSql('ALTER TABLE profile_experience DROP FOREIGN KEY FK_C2FBF65E46E90E27');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_game_role');
        $this->addSql('DROP TABLE profile_experience');
        $this->addSql('ALTER TABLE user CHANGE languages languages LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }
}
