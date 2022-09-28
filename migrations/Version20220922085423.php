<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922085423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_1173F10567B339C5');
        $this->addSql('DROP INDEX IDX_1173F10567B339C5 ON client');
        $this->addSql('ALTER TABLE client DROP user_id');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_2FB3D0EEFCFA9DAE');
        $this->addSql('DROP INDEX idx_2fb3d0eefcfa9dae ON intervention');
        $this->addSql('CREATE INDEX IDX_D11814AB3F192FC ON intervention (operateur_id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_2FB3D0EEFCFA9DAE FOREIGN KEY (operateur_id) REFERENCES operateur (id)');
        $this->addSql('ALTER TABLE operateur DROP FOREIGN KEY FK_1173F105166D1F9C');
        $this->addSql('DROP INDEX IDX_1173F105166D1F9C ON operateur');
        $this->addSql('ALTER TABLE operateur DROP user_id');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_2FB3D0EE67B339C5');
        $this->addSql('DROP INDEX IDX_2FB3D0EE67B339C5 ON rapport');
        $this->addSql('ALTER TABLE rapport DROP operateur_id');
        $this->addSql('ALTER TABLE securite DROP FOREIGN KEY FK_E48E50F6A76ED395');
        $this->addSql('DROP INDEX IDX_E48E50F6A76ED395 ON securite');
        $this->addSql('ALTER TABLE securite DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB3F192FC');
        $this->addSql('DROP INDEX idx_d11814ab3f192fc ON intervention');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEFCFA9DAE ON intervention (operateur_id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB3F192FC FOREIGN KEY (operateur_id) REFERENCES operateur (id)');
        $this->addSql('ALTER TABLE securite ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE securite ADD CONSTRAINT FK_E48E50F6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E48E50F6A76ED395 ON securite (user_id)');
        $this->addSql('ALTER TABLE operateur ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operateur ADD CONSTRAINT FK_1173F105166D1F9C FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1173F105166D1F9C ON operateur (user_id)');
        $this->addSql('ALTER TABLE rapport ADD operateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_2FB3D0EE67B339C5 FOREIGN KEY (operateur_id) REFERENCES operateur (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE67B339C5 ON rapport (operateur_id)');
        $this->addSql('ALTER TABLE client ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_1173F10567B339C5 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1173F10567B339C5 ON client (user_id)');
    }
}
