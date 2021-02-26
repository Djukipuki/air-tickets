<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225181423 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE airport (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, timezone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route_schedule (id INT AUTO_INCREMENT NOT NULL, transport_route_id INT NOT NULL, departure_date_time DATETIME NOT NULL, arrival_date_time DATETIME NOT NULL, INDEX IDX_A41459D0FEC2A1AC (transport_route_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport_route (id INT AUTO_INCREMENT NOT NULL, transporter_id INT NOT NULL, departure_airport_id INT NOT NULL, arrival_airport_id INT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, INDEX IDX_9FCB87814F335C8B (transporter_id), INDEX IDX_9FCB8781F631AB5C (departure_airport_id), INDEX IDX_9FCB87817F43E343 (arrival_airport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transporter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE route_schedule ADD CONSTRAINT FK_A41459D0FEC2A1AC FOREIGN KEY (transport_route_id) REFERENCES transport_route (id)');
        $this->addSql('ALTER TABLE transport_route ADD CONSTRAINT FK_9FCB87814F335C8B FOREIGN KEY (transporter_id) REFERENCES transporter (id)');
        $this->addSql('ALTER TABLE transport_route ADD CONSTRAINT FK_9FCB8781F631AB5C FOREIGN KEY (departure_airport_id) REFERENCES airport (id)');
        $this->addSql('ALTER TABLE transport_route ADD CONSTRAINT FK_9FCB87817F43E343 FOREIGN KEY (arrival_airport_id) REFERENCES airport (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transport_route DROP FOREIGN KEY FK_9FCB8781F631AB5C');
        $this->addSql('ALTER TABLE transport_route DROP FOREIGN KEY FK_9FCB87817F43E343');
        $this->addSql('ALTER TABLE route_schedule DROP FOREIGN KEY FK_A41459D0FEC2A1AC');
        $this->addSql('ALTER TABLE transport_route DROP FOREIGN KEY FK_9FCB87814F335C8B');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE route_schedule');
        $this->addSql('DROP TABLE transport_route');
        $this->addSql('DROP TABLE transporter');
        $this->addSql('DROP TABLE user');
    }
}
