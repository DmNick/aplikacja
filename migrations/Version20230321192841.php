<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321192841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD id_magazynu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497565D2EE FOREIGN KEY (id_magazynu_id) REFERENCES magazyn (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6497565D2EE ON user (id_magazynu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497565D2EE');
        $this->addSql('DROP INDEX IDX_8D93D6497565D2EE ON user');
        $this->addSql('ALTER TABLE user DROP id_magazynu_id');
    }
}
