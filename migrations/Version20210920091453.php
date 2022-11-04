<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920091453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE truck ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CDCCF30AA76ED395 ON truck (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30AA76ED395');
        $this->addSql('DROP INDEX UNIQ_CDCCF30AA76ED395 ON truck');
        $this->addSql('ALTER TABLE truck DROP user_id');
    }
}
