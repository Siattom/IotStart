<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830140417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, adresse VARCHAR(255) NOT NULL, nd INT NOT NULL, activity VARCHAR(255) DEFAULT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, tel INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, INDEX IDX_1173F10567B339C5 (user_id),PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, operateur_id INT DEFAULT NULL, n°ot INT NOT NULL, description LONGTEXT NOT NULL, start_work DATETIME DEFAULT NULL, cloture TINYINT(1) NOT NULL, cloture_finale DATETIME DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, INDEX IDX_2FB3D0EEFCFA9DAE (operateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE operateur (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, INDEX IDX_1173F105166D1F9C (user_id),PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, operateur_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL,  INDEX IDX_2FB3D0EE67B339C5 (operateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE securite (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, INDEX IDX_E48E50F6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_1173F10567B339C5 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operateur ADD CONSTRAINT FK_1173F105166D1F9C FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_2FB3D0EEFCFA9DAE FOREIGN KEY (operateur_id) REFERENCES operateur (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_2FB3D0EE67B339C5 FOREIGN KEY (operateur_id) REFERENCES operateur (id)');
        $this->addSql('ALTER TABLE securite ADD CONSTRAINT FK_E48E50F6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_2FB3D0EEFCFA9DAE');
        $this->addSql('ALTER TABLE operateur DROP FOREIGN KEY FK_1173F105166D1F9C');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_1173F10567B339C5');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_2FB3D0EE67B339C5');
        $this->addSql('ALTER TABLE securite DROP FOREIGN KEY FK_E48E50F6A76ED395');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE operateur');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE securite');
        $this->addSql('DROP TABLE user');
    }
}
