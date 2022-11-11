<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003082828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE securite ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE securite ADD CONSTRAINT FK_D19A898E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_D19A898E19EB6921 ON securite (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE securite DROP FOREIGN KEY FK_D19A898E19EB6921');
        $this->addSql('DROP INDEX IDX_D19A898E19EB6921 ON securite');
        $this->addSql('ALTER TABLE securite DROP client_id');
    }
}
