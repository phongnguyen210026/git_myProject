<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222144823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail ADD order_id_id INT NOT NULL, ADD product_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46FCDAEAAA FOREIGN KEY (order_id_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_ED896F46FCDAEAAA ON order_detail (order_id_id)');
        $this->addSql('CREATE INDEX IDX_ED896F46DE18E50B ON order_detail (product_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46FCDAEAAA');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46DE18E50B');
        $this->addSql('DROP INDEX IDX_ED896F46FCDAEAAA ON order_detail');
        $this->addSql('DROP INDEX IDX_ED896F46DE18E50B ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP order_id_id, DROP product_id_id');
    }
}
