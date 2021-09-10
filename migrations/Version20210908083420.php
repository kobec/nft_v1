<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908083420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_user_networks (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_user_id)\', network VARCHAR(32) DEFAULT NULL, identity VARCHAR(32) DEFAULT NULL, INDEX IDX_D7BAFD7BA76ED395 (user_id), UNIQUE INDEX UNIQ_D7BAFD7B608487BC6A95E9C4 (network, identity), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:user_user_id)\', date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', email VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:user_user_email)\', password_hash VARCHAR(255) DEFAULT NULL, confirm_token VARCHAR(255) DEFAULT NULL, new_email VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:user_user_email)\', new_email_token VARCHAR(255) DEFAULT NULL, status VARCHAR(16) NOT NULL, role VARCHAR(16) NOT NULL COMMENT \'(DC2Type:user_user_role)\', version INT DEFAULT 1 NOT NULL, name_first VARCHAR(255) NOT NULL, name_last VARCHAR(255) NOT NULL, reset_token_token VARCHAR(255) DEFAULT NULL, reset_token_expires DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_F6415EB1E7927C74 (email), UNIQUE INDEX UNIQ_F6415EB186EC69F0 (reset_token_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_user_networks ADD CONSTRAINT FK_D7BAFD7BA76ED395 FOREIGN KEY (user_id) REFERENCES user_users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_user_networks DROP FOREIGN KEY FK_D7BAFD7BA76ED395');
        $this->addSql('DROP TABLE user_user_networks');
        $this->addSql('DROP TABLE user_users');
    }
}
