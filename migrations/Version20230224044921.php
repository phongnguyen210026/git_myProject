<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224044921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_detail ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_detail ADD CONSTRAINT FK_4C7A3E374584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_4C7A3E374584665A ON product_detail (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_detail DROP FOREIGN KEY FK_4C7A3E374584665A');
        $this->addSql('DROP INDEX IDX_4C7A3E374584665A ON product_detail');
        $this->addSql('ALTER TABLE product_detail DROP product_id');
    }
}
