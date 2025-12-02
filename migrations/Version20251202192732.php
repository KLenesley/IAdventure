<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251202192732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_avatar (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_enigma (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, type_id INT NOT NULL, title VARCHAR(255) NOT NULL, instruction LONGTEXT DEFAULT NULL, secret_code VARCHAR(255) NOT NULL, `order` INT NOT NULL, INDEX IDX_A30FBED1E48FD905 (game_id), INDEX IDX_A30FBED1C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_enigma_thumbnail (enigma_id INT NOT NULL, thumbnail_id INT NOT NULL, INDEX IDX_11DDA3DC457B6BA0 (enigma_id), INDEX IDX_11DDA3DCFDFF2E92 (thumbnail_id), PRIMARY KEY(enigma_id, thumbnail_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_game (id INT AUTO_INCREMENT NOT NULL, creator_id INT NOT NULL, title VARCHAR(255) NOT NULL, welcome_msg LONGTEXT DEFAULT NULL, welcome_img VARCHAR(255) DEFAULT NULL, INDEX IDX_960B646461220EA6 (creator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_game_session (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, started_at DATETIME NOT NULL, completed_at DATETIME DEFAULT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_BBD5D06DE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_setting (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, UNIQUE INDEX UNIQ_C427B0ECE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_team (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, position INT NOT NULL, current_enigma INT NOT NULL, note LONGTEXT DEFAULT NULL, INDEX IDX_71C0F3F786383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_team_progress (id INT AUTO_INCREMENT NOT NULL, team_session_id INT NOT NULL, enigma_id INT NOT NULL, timestamp DATETIME NOT NULL, action VARCHAR(50) NOT NULL, details LONGTEXT DEFAULT NULL, INDEX IDX_83D14B335FE69E1A (team_session_id), INDEX IDX_83D14B33457B6BA0 (enigma_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_team_session (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, game_session_id INT NOT NULL, current_enigma_order INT NOT NULL, started_at DATETIME NOT NULL, completed_at DATETIME DEFAULT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_D16EDE75296CD8AE (team_id), INDEX IDX_D16EDE758FE32B32 (game_session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_thumbnail (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, information LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tbl_user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tbl_enigma ADD CONSTRAINT FK_A30FBED1E48FD905 FOREIGN KEY (game_id) REFERENCES tbl_game (id)');
        $this->addSql('ALTER TABLE tbl_enigma ADD CONSTRAINT FK_A30FBED1C54C8C93 FOREIGN KEY (type_id) REFERENCES tbl_type (id)');
        $this->addSql('ALTER TABLE tbl_enigma_thumbnail ADD CONSTRAINT FK_11DDA3DC457B6BA0 FOREIGN KEY (enigma_id) REFERENCES tbl_enigma (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tbl_enigma_thumbnail ADD CONSTRAINT FK_11DDA3DCFDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES tbl_thumbnail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tbl_game ADD CONSTRAINT FK_960B646461220EA6 FOREIGN KEY (creator_id) REFERENCES tbl_user (id)');
        $this->addSql('ALTER TABLE tbl_game_session ADD CONSTRAINT FK_BBD5D06DE48FD905 FOREIGN KEY (game_id) REFERENCES tbl_game (id)');
        $this->addSql('ALTER TABLE tbl_setting ADD CONSTRAINT FK_C427B0ECE48FD905 FOREIGN KEY (game_id) REFERENCES tbl_game (id)');
        $this->addSql('ALTER TABLE tbl_team ADD CONSTRAINT FK_71C0F3F786383B10 FOREIGN KEY (avatar_id) REFERENCES tbl_avatar (id)');
        $this->addSql('ALTER TABLE tbl_team_progress ADD CONSTRAINT FK_83D14B335FE69E1A FOREIGN KEY (team_session_id) REFERENCES tbl_team_session (id)');
        $this->addSql('ALTER TABLE tbl_team_progress ADD CONSTRAINT FK_83D14B33457B6BA0 FOREIGN KEY (enigma_id) REFERENCES tbl_enigma (id)');
        $this->addSql('ALTER TABLE tbl_team_session ADD CONSTRAINT FK_D16EDE75296CD8AE FOREIGN KEY (team_id) REFERENCES tbl_team (id)');
        $this->addSql('ALTER TABLE tbl_team_session ADD CONSTRAINT FK_D16EDE758FE32B32 FOREIGN KEY (game_session_id) REFERENCES tbl_game_session (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_enigma DROP FOREIGN KEY FK_A30FBED1E48FD905');
        $this->addSql('ALTER TABLE tbl_enigma DROP FOREIGN KEY FK_A30FBED1C54C8C93');
        $this->addSql('ALTER TABLE tbl_enigma_thumbnail DROP FOREIGN KEY FK_11DDA3DC457B6BA0');
        $this->addSql('ALTER TABLE tbl_enigma_thumbnail DROP FOREIGN KEY FK_11DDA3DCFDFF2E92');
        $this->addSql('ALTER TABLE tbl_game DROP FOREIGN KEY FK_960B646461220EA6');
        $this->addSql('ALTER TABLE tbl_game_session DROP FOREIGN KEY FK_BBD5D06DE48FD905');
        $this->addSql('ALTER TABLE tbl_setting DROP FOREIGN KEY FK_C427B0ECE48FD905');
        $this->addSql('ALTER TABLE tbl_team DROP FOREIGN KEY FK_71C0F3F786383B10');
        $this->addSql('ALTER TABLE tbl_team_progress DROP FOREIGN KEY FK_83D14B335FE69E1A');
        $this->addSql('ALTER TABLE tbl_team_progress DROP FOREIGN KEY FK_83D14B33457B6BA0');
        $this->addSql('ALTER TABLE tbl_team_session DROP FOREIGN KEY FK_D16EDE75296CD8AE');
        $this->addSql('ALTER TABLE tbl_team_session DROP FOREIGN KEY FK_D16EDE758FE32B32');
        $this->addSql('DROP TABLE tbl_avatar');
        $this->addSql('DROP TABLE tbl_enigma');
        $this->addSql('DROP TABLE tbl_enigma_thumbnail');
        $this->addSql('DROP TABLE tbl_game');
        $this->addSql('DROP TABLE tbl_game_session');
        $this->addSql('DROP TABLE tbl_setting');
        $this->addSql('DROP TABLE tbl_team');
        $this->addSql('DROP TABLE tbl_team_progress');
        $this->addSql('DROP TABLE tbl_team_session');
        $this->addSql('DROP TABLE tbl_thumbnail');
        $this->addSql('DROP TABLE tbl_type');
        $this->addSql('DROP TABLE tbl_user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
