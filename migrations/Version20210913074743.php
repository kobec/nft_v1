<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913074743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract_contract_nft_txs CHANGE block_number block_number BIGINT NOT NULL, CHANGE gas_gas gas_gas BIGINT NOT NULL, CHANGE gas_price gas_price BIGINT NOT NULL, CHANGE gas_used gas_used BIGINT NOT NULL, CHANGE gas_cumulative_gas_used gas_cumulative_gas_used BIGINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE contract_contract_nft_txs CHANGE block_number block_number INT NOT NULL, CHANGE gas_gas gas_gas INT NOT NULL, CHANGE gas_price gas_price INT NOT NULL, CHANGE gas_used gas_used INT NOT NULL, CHANGE gas_cumulative_gas_used gas_cumulative_gas_used INT NOT NULL');
    }
}