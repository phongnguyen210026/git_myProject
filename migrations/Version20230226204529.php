<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226204529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B74584665A');
        $this->addSql('DROP INDEX fk_ba388b74584665a ON cart');
        $this->addSql('CREATE INDEX IDX_BA388B74584665A ON cart (product_id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B74584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_detail ADD od_id INT NOT NULL, ADD products_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46F0046BF7 FOREIGN KEY (od_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F466C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_ED896F46F0046BF7 ON order_detail (od_id)');
        $this->addSql('CREATE INDEX IDX_ED896F466C8A81A9 ON order_detail (products_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cart DROP INDEX UNIQ_BA388B7A76ED395, ADD INDEX FK_BA388B7A76ED395 (user_id)');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B74584665A');
        $this->addSql('DROP INDEX idx_ba388b74584665a ON cart');
        $this->addSql('CREATE INDEX FK_BA388B74584665A ON cart (product_id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B74584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46F0046BF7');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F466C8A81A9');
        $this->addSql('DROP INDEX IDX_ED896F46F0046BF7 ON order_detail');
        $this->addSql('DROP INDEX IDX_ED896F466C8A81A9 ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP od_id, DROP products_id');
    }
}
