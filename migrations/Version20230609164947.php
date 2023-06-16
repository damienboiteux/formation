<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609164947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questionnaire ADD formateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF155D8F51 FOREIGN KEY (formateur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7A64DAF155D8F51 ON questionnaire (formateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF155D8F51');
        $this->addSql('DROP INDEX IDX_7A64DAF155D8F51 ON questionnaire');
        $this->addSql('ALTER TABLE questionnaire DROP formateur_id');
    }
}
