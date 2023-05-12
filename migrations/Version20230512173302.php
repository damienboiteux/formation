<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512173302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return ''; 
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE questionnaire ADD matiere_id INT DEFAULT NULL, DROP matiere');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAFF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAFF46CD258 ON questionnaire (matiere_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAFF46CD258');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP INDEX IDX_7A64DAFF46CD258 ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire ADD matiere VARCHAR(255) NOT NULL, DROP matiere_id');
    }
}
