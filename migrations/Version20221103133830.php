<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103133830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_operateur (user_id INT NOT NULL, operateur_id INT NOT NULL, INDEX IDX_B4577479A76ED395 (user_id), INDEX IDX_B45774793F192FC (operateur_id), PRIMARY KEY(user_id, operateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_operateur ADD CONSTRAINT FK_B4577479A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_operateur ADD CONSTRAINT FK_B45774793F192FC FOREIGN KEY (operateur_id) REFERENCES operateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rapport ADD intervention_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C8EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('CREATE INDEX IDX_BE34A09C8EAE3863 ON rapport (intervention_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_operateur DROP FOREIGN KEY FK_B4577479A76ED395');
        $this->addSql('ALTER TABLE user_operateur DROP FOREIGN KEY FK_B45774793F192FC');
        $this->addSql('DROP TABLE user_operateur');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C8EAE3863');
        $this->addSql('DROP INDEX IDX_BE34A09C8EAE3863 ON rapport');
        $this->addSql('ALTER TABLE rapport DROP intervention_id');
    }
}
