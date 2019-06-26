<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190620170529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie_offre (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence_offre (id INT AUTO_INCREMENT NOT NULL, offre_id INT NOT NULL, competence_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_25A4D7894CC8505A (offre_id), INDEX IDX_25A4D78915761DAB (competence_id), INDEX IDX_25A4D789B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discussion (id INT AUTO_INCREMENT NOT NULL, expediteur_id INT NOT NULL, destinataire_id INT NOT NULL, message_id INT NOT NULL, INDEX IDX_C0B9F90F10335F61 (expediteur_id), INDEX IDX_C0B9F90FA4F84F6E (destinataire_id), UNIQUE INDEX UNIQ_C0B9F90F537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(500) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, lieu_id INT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, frais_inscription DOUBLE PRECISION NOT NULL, frais_formation DOUBLE PRECISION NOT NULL, fin_demande DATETIME NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, INDEX IDX_404021BF6AB213CC (lieu_id), INDEX IDX_404021BF60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_prerequis (formation_id INT NOT NULL, prerequis_id INT NOT NULL, INDEX IDX_9EBBD45200282E (formation_id), INDEX IDX_9EBBD4ED196790 (prerequis_id), PRIMARY KEY(formation_id, prerequis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_particulier (formation_id INT NOT NULL, particulier_id INT NOT NULL, INDEX IDX_3339F4285200282E (formation_id), INDEX IDX_3339F428A89E0E67 (particulier_id), PRIMARY KEY(formation_id, particulier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, contenu LONGTEXT NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, nb_experience INT NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, remuneration DOUBLE PRECISION NOT NULL, duree INT DEFAULT NULL, fin_demande DATETIME NOT NULL, INDEX IDX_AF86866FBCF5E72D (categorie_id), INDEX IDX_AF86866F60BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_particulier (offre_id INT NOT NULL, particulier_id INT NOT NULL, INDEX IDX_27ED5ED34CC8505A (offre_id), INDEX IDX_27ED5ED3A89E0E67 (particulier_id), PRIMARY KEY(offre_id, particulier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE particulier_experience (particulier_id INT NOT NULL, experience_id INT NOT NULL, INDEX IDX_426FF895A89E0E67 (particulier_id), INDEX IDX_426FF89546E90E27 (experience_id), PRIMARY KEY(particulier_id, experience_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prerequis (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(500) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence_offre ADD CONSTRAINT FK_25A4D7894CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE competence_offre ADD CONSTRAINT FK_25A4D78915761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence_offre ADD CONSTRAINT FK_25A4D789B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F10335F61 FOREIGN KEY (expediteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90FA4F84F6E FOREIGN KEY (destinataire_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discussion ADD CONSTRAINT FK_C0B9F90F537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF6AB213CC FOREIGN KEY (lieu_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE formation_prerequis ADD CONSTRAINT FK_9EBBD45200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_prerequis ADD CONSTRAINT FK_9EBBD4ED196790 FOREIGN KEY (prerequis_id) REFERENCES prerequis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_particulier ADD CONSTRAINT FK_3339F4285200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_particulier ADD CONSTRAINT FK_3339F428A89E0E67 FOREIGN KEY (particulier_id) REFERENCES particulier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_offre (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE offre_particulier ADD CONSTRAINT FK_27ED5ED34CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_particulier ADD CONSTRAINT FK_27ED5ED3A89E0E67 FOREIGN KEY (particulier_id) REFERENCES particulier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE particulier_experience ADD CONSTRAINT FK_426FF895A89E0E67 FOREIGN KEY (particulier_id) REFERENCES particulier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE particulier_experience ADD CONSTRAINT FK_426FF89546E90E27 FOREIGN KEY (experience_id) REFERENCES experience (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBCF5E72D');
        $this->addSql('ALTER TABLE competence_offre DROP FOREIGN KEY FK_25A4D78915761DAB');
        $this->addSql('ALTER TABLE particulier_experience DROP FOREIGN KEY FK_426FF89546E90E27');
        $this->addSql('ALTER TABLE formation_prerequis DROP FOREIGN KEY FK_9EBBD45200282E');
        $this->addSql('ALTER TABLE formation_particulier DROP FOREIGN KEY FK_3339F4285200282E');
        $this->addSql('ALTER TABLE discussion DROP FOREIGN KEY FK_C0B9F90F537A1329');
        $this->addSql('ALTER TABLE competence_offre DROP FOREIGN KEY FK_25A4D789B3E9C81');
        $this->addSql('ALTER TABLE competence_offre DROP FOREIGN KEY FK_25A4D7894CC8505A');
        $this->addSql('ALTER TABLE offre_particulier DROP FOREIGN KEY FK_27ED5ED34CC8505A');
        $this->addSql('ALTER TABLE formation_prerequis DROP FOREIGN KEY FK_9EBBD4ED196790');
        $this->addSql('DROP TABLE categorie_offre');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_offre');
        $this->addSql('DROP TABLE discussion');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_prerequis');
        $this->addSql('DROP TABLE formation_particulier');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE offre_particulier');
        $this->addSql('DROP TABLE particulier_experience');
        $this->addSql('DROP TABLE prerequis');
    }
}
