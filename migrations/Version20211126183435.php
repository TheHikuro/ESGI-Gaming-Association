<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211126183435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_association (user_id INT NOT NULL, association_id INT NOT NULL, INDEX IDX_549EE859A76ED395 (user_id), INDEX IDX_549EE859EFB9C8A5 (association_id), PRIMARY KEY(user_id, association_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_association ADD CONSTRAINT FK_549EE859A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_association ADD CONSTRAINT FK_549EE859EFB9C8A5 FOREIGN KEY (association_id) REFERENCES association (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD section_id INT NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD pseudo VARCHAR(255) DEFAULT NULL, ADD avatar VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD create_date DATETIME NOT NULL, ADD comfirm_token VARCHAR(255) DEFAULT NULL, ADD password_recover_token VARCHAR(255) DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D823E37A ON user (section_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_association');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649D823E37A');
        $this->addSql('DROP INDEX IDX_8D93D649D823E37A ON `user`');
        $this->addSql('ALTER TABLE `user` DROP section_id, DROP name, DROP lastname, DROP pseudo, DROP avatar, DROP description, DROP create_date, DROP comfirm_token, DROP password_recover_token, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
