<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226202740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD users_id INT NOT NULL, ADD address VARCHAR(2000) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F529939867B3B43D ON `order` (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP INDEX UNIQ_BA388B7A76ED395, ADD INDEX IDX_BA388B7A76ED395 (user_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939867B3B43D');
        $this->addSql('DROP INDEX IDX_F529939867B3B43D ON `order`');
        $this->addSql('ALTER TABLE `order` DROP users_id, DROP address');
    }
}
