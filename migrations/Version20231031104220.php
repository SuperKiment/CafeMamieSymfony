<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231031104220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_9B76551F76C50E4A (proprietaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier_categorie (fichier_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_6D7113A4F915CFE (fichier_id), INDEX IDX_6D7113A4BCF5E72D (categorie_id), PRIMARY KEY(fichier_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fichier_categorie ADD CONSTRAINT FK_6D7113A4F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fichier_categorie ADD CONSTRAINT FK_6D7113A4BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F76C50E4A');
        $this->addSql('ALTER TABLE fichier_categorie DROP FOREIGN KEY FK_6D7113A4F915CFE');
        $this->addSql('ALTER TABLE fichier_categorie DROP FOREIGN KEY FK_6D7113A4BCF5E72D');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE fichier_categorie');
    }
}
