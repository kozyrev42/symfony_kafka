<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * 
 * накатить миграции
 * php bin/console doctrine:migrations:migrate

 * откатить последнюю миграцию
 * php bin/console doctrine:migrations:migrate prev
 * 
 * php bin/console doctrine:migrations:diff
 * команда создаст файл-миграцию, на основе entity, если такой миграции ещё не было создано
 */
final class Version20240920083423 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE posts (
            id SERIAL PRIMARY KEY,
            body TEXT NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE posts');
    }
}
