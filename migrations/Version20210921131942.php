<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210921131942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_user_networks ADD data JSON DEFAULT NULL, CHANGE identity identity VARCHAR(64) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_users ADD username VARCHAR(255) DEFAULT NULL, CHANGE name_first name_first VARCHAR(255) DEFAULT NULL, CHANGE name_last name_last VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1F85E0677 ON user_users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_user_networks DROP data, CHANGE identity identity VARCHAR(32) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_F6415EB1F85E0677 ON user_users');
        $this->addSql('ALTER TABLE user_users DROP username, CHANGE name_first name_first VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name_last name_last VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
