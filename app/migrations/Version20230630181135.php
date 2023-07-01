<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630181135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, place VARCHAR(15) DEFAULT NULL, tournament_name VARCHAR(255) NOT NULL, tournament_link VARCHAR(255) DEFAULT NULL, tournament_logo VARCHAR(255) DEFAULT NULL, team_name VARCHAR(100) NOT NULL, team_logo VARCHAR(255) DEFAULT NULL, INDEX IDX_590C103CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_game_role (game_id INT NOT NULL, game_role_id INT NOT NULL, INDEX IDX_6EDA2744E48FD905 (game_id), INDEX IDX_6EDA274443C15D83 (game_role_id), PRIMARY KEY(game_id, game_role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, game_id INT NOT NULL, team_id INT DEFAULT NULL, ingame_name VARCHAR(70) NOT NULL, bio LONGTEXT DEFAULT NULL, montage VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8157AA0FA76ED395 (user_id), INDEX IDX_8157AA0FE48FD905 (game_id), INDEX IDX_8157AA0F296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_game_role (profile_id INT NOT NULL, game_role_id INT NOT NULL, INDEX IDX_E30F3DCCFA12B8 (profile_id), INDEX IDX_E30F3D43C15D83 (game_role_id), PRIMARY KEY(profile_id, game_role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_media (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, team_id INT DEFAULT NULL, discord VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, instagram VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, vk VARCHAR(255) DEFAULT NULL, twitch VARCHAR(255) DEFAULT NULL, youtube VARCHAR(255) DEFAULT NULL, tiktok VARCHAR(255) DEFAULT NULL, INDEX IDX_20BC159EA76ED395 (user_id), INDEX IDX_20BC159E296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, game_id INT NOT NULL, team_name VARCHAR(100) NOT NULL, password VARCHAR(30) NOT NULL, team_url VARCHAR(60) NOT NULL, overview LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C4E0A61F7E3C61F9 (owner_id), UNIQUE INDEX UNIQ_C4E0A61FE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(30) NOT NULL, last_name VARCHAR(30) NOT NULL, username VARCHAR(50) NOT NULL, nickname VARCHAR(50) DEFAULT NULL, gender VARCHAR(50) NOT NULL, birthday DATETIME NOT NULL, avatar VARCHAR(50) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, is_first_login TINYINT(1) NOT NULL, ban_start DATETIME DEFAULT NULL, ban_end DATETIME DEFAULT NULL, ban_reason VARCHAR(255) DEFAULT NULL, premium_start DATETIME DEFAULT NULL, premium_end DATETIME DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', country VARCHAR(255) NOT NULL, languages JSON DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE game_game_role ADD CONSTRAINT FK_6EDA2744E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_role ADD CONSTRAINT FK_6EDA274443C15D83 FOREIGN KEY (game_role_id) REFERENCES game_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE profile_game_role ADD CONSTRAINT FK_E30F3DCCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_game_role ADD CONSTRAINT FK_E30F3D43C15D83 FOREIGN KEY (game_role_id) REFERENCES game_role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE social_media ADD CONSTRAINT FK_20BC159EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE social_media ADD CONSTRAINT FK_20BC159E296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103CCFA12B8');
        $this->addSql('ALTER TABLE game_game_role DROP FOREIGN KEY FK_6EDA2744E48FD905');
        $this->addSql('ALTER TABLE game_game_role DROP FOREIGN KEY FK_6EDA274443C15D83');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FE48FD905');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F296CD8AE');
        $this->addSql('ALTER TABLE profile_game_role DROP FOREIGN KEY FK_E30F3DCCFA12B8');
        $this->addSql('ALTER TABLE profile_game_role DROP FOREIGN KEY FK_E30F3D43C15D83');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE social_media DROP FOREIGN KEY FK_20BC159EA76ED395');
        $this->addSql('ALTER TABLE social_media DROP FOREIGN KEY FK_20BC159E296CD8AE');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F7E3C61F9');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FE48FD905');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_game_role');
        $this->addSql('DROP TABLE game_role');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_game_role');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE social_media');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
    }
}
