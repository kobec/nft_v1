<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910090423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contract_contract_nft_txs (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', contract_id CHAR(36) NOT NULL COMMENT \'(DC2Type:contract_contract_id)\', hash VARCHAR(128) NOT NULL, transaction_index INT NOT NULL, confirmations INT NOT NULL, nonce INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, block_number INT NOT NULL, block_hash VARCHAR(128) NOT NULL, transfer_from VARCHAR(64) NOT NULL, transfer_to VARCHAR(64) NOT NULL, token_id INT NOT NULL, token_name VARCHAR(48) NOT NULL, token_symbol VARCHAR(12) NOT NULL, token_decimal NUMERIC(10, 0) NOT NULL, gas_gas INT NOT NULL, gas_price INT NOT NULL, gas_used INT NOT NULL, gas_cumulative_gas_used INT NOT NULL, INDEX IDX_2F8C76392576E0FD (contract_id), UNIQUE INDEX UNIQ_2F8C7639D1B862B8 (hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract_contracts (id CHAR(36) NOT NULL COMMENT \'(DC2Type:contract_contract_id)\', address VARCHAR(255) DEFAULT NULL, standard VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:contract_contract_standard)\', version INT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_24C7F1E5D4E6F81 (address), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract_contract_nft_txs ADD CONSTRAINT FK_2F8C76392576E0FD FOREIGN KEY (contract_id) REFERENCES contract_contracts (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract_contract_nft_txs DROP FOREIGN KEY FK_2F8C76392576E0FD');
        $this->addSql('DROP TABLE contract_contract_nft_txs');
        $this->addSql('DROP TABLE contract_contracts');
    }
}
