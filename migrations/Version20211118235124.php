<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118235124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AECC28B580');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AECC28B580 FOREIGN KEY (idvoiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY FK_386829AECC28B580');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT FK_386829AECC28B580 FOREIGN KEY (idvoiture_id) REFERENCES voiture (id)');
    }
}
