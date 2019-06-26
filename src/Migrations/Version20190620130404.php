<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190620130404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE langue_parle (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE particulier_langue_parle (particulier_id INT NOT NULL, langue_parle_id INT NOT NULL, INDEX IDX_51AEAFA4A89E0E67 (particulier_id), INDEX IDX_51AEAFA4720496A0 (langue_parle_id), PRIMARY KEY(particulier_id, langue_parle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE particulier_langue_parle ADD CONSTRAINT FK_51AEAFA4A89E0E67 FOREIGN KEY (particulier_id) REFERENCES particulier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE particulier_langue_parle ADD CONSTRAINT FK_51AEAFA4720496A0 FOREIGN KEY (langue_parle_id) REFERENCES langue_parle (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE particulier_langue_parle DROP FOREIGN KEY FK_51AEAFA4720496A0');
        $this->addSql('DROP TABLE langue_parle');
        $this->addSql('DROP TABLE particulier_langue_parle');
    }
}
