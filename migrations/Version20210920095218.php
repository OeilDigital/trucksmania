<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920095218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, gps_id INT DEFAULT NULL, street_number VARCHAR(100) NOT NULL, street_name VARCHAR(100) NOT NULL, post_code VARCHAR(100) NOT NULL, city VARCHAR(100) NOT NULL, additional_address LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_D4E6F81BD6B6DDE (gps_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address_truck (address_id INT NOT NULL, truck_id INT NOT NULL, INDEX IDX_FA69842AF5B7AF75 (address_id), INDEX IDX_FA69842AC6957CCE (truck_id), PRIMARY KEY(address_id, truck_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81BD6B6DDE FOREIGN KEY (gps_id) REFERENCES gps (id)');
        $this->addSql('ALTER TABLE address_truck ADD CONSTRAINT FK_FA69842AF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address_truck ADD CONSTRAINT FK_FA69842AC6957CCE FOREIGN KEY (truck_id) REFERENCES truck (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_truck DROP FOREIGN KEY FK_FA69842AF5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE address_truck');
    }
}
