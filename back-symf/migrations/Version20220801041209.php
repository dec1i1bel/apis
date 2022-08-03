<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220801041209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE city_places (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR (100) NOT NULL,
            latitude FLOAT NOT NULL,
            longitude FLOAT NOT NULL,
            city_id BIGINT UNSIGNED,
            PRIMARY KEY (id) ,
            FOREIGN KEY (city_id) REFERENCES wikidata_cities (id)
            ) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ENGINE=InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE city_places');
    }
}
