<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230103154859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite_technique ADD operateur_id INT DEFAULT NULL, ADD intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE visite_technique ADD CONSTRAINT FK_348A54D73F192FC FOREIGN KEY (operateur_id) REFERENCES operateur (id)');
        $this->addSql('ALTER TABLE visite_technique ADD CONSTRAINT FK_348A54D78EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('CREATE INDEX IDX_348A54D73F192FC ON visite_technique (operateur_id)');
        $this->addSql('CREATE INDEX IDX_348A54D78EAE3863 ON visite_technique (intervention_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE visite_technique DROP FOREIGN KEY FK_348A54D73F192FC');
        $this->addSql('ALTER TABLE visite_technique DROP FOREIGN KEY FK_348A54D78EAE3863');
        $this->addSql('DROP INDEX IDX_348A54D73F192FC ON visite_technique');
        $this->addSql('DROP INDEX IDX_348A54D78EAE3863 ON visite_technique');
        $this->addSql('ALTER TABLE visite_technique DROP operateur_id, DROP intervention_id');
        $this->addSql('ALTER TABLE user');
    }
}
