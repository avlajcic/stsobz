<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190105131955 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE player_score (id INT AUTO_INCREMENT NOT NULL, season_id INT DEFAULT NULL, league_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, won INT NOT NULL, lost INT NOT NULL, INDEX IDX_8DEB4C174EC001D1 (season_id), INDEX IDX_8DEB4C1758AFC4DE (league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player_score ADD CONSTRAINT FK_8DEB4C174EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE player_score ADD CONSTRAINT FK_8DEB4C1758AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE player_score');
    }
}
