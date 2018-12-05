<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181028183512 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE club (id INT AUTO_INCREMENT NOT NULL, league_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B8EE387258AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_match (id INT AUTO_INCREMENT NOT NULL, home_club_id INT DEFAULT NULL, away_club_id INT DEFAULT NULL, round_id INT DEFAULT NULL, home_club_score INT NOT NULL, away_club_score INT NOT NULL, INDEX IDX_4868BC8AD439C16A (home_club_id), INDEX IDX_4868BC8AD6D8F9E (away_club_id), INDEX IDX_4868BC8AA6005CA0 (round_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE round (id INT AUTO_INCREMENT NOT NULL, season_id INT DEFAULT NULL, league_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C5EEEA344EC001D1 (season_id), INDEX IDX_C5EEEA3458AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F0E45BA95E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE club ADD CONSTRAINT FK_B8EE387258AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE game_match ADD CONSTRAINT FK_4868BC8AD439C16A FOREIGN KEY (home_club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE game_match ADD CONSTRAINT FK_4868BC8AD6D8F9E FOREIGN KEY (away_club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE game_match ADD CONSTRAINT FK_4868BC8AA6005CA0 FOREIGN KEY (round_id) REFERENCES round (id)');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA344EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE round ADD CONSTRAINT FK_C5EEEA3458AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE game_match DROP FOREIGN KEY FK_4868BC8AD439C16A');
        $this->addSql('ALTER TABLE game_match DROP FOREIGN KEY FK_4868BC8AD6D8F9E');
        $this->addSql('ALTER TABLE club DROP FOREIGN KEY FK_B8EE387258AFC4DE');
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA3458AFC4DE');
        $this->addSql('ALTER TABLE game_match DROP FOREIGN KEY FK_4868BC8AA6005CA0');
        $this->addSql('ALTER TABLE round DROP FOREIGN KEY FK_C5EEEA344EC001D1');
        $this->addSql('DROP TABLE club');
        $this->addSql('DROP TABLE game_match');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE round');
        $this->addSql('DROP TABLE season');
    }
}
