<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration
 */
final class Version20220806045335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adds <distance> column to <city_places> table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE city_places ADD distance FLOAT(15)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE city_places DROP COLUMN distance');
    }
}
