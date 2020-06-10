<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200610195136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, added_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (code VARCHAR(10) NOT NULL, customer_id INT NOT NULL, name VARCHAR(100) NOT NULL, path VARCHAR(255) NOT NULL, lock_path VARCHAR(255) NOT NULL, php_path VARCHAR(255) NOT NULL, private_dependencies LONGTEXT DEFAULT NULL, private_dependencies_strategy VARCHAR(10) DEFAULT NULL, check_dependencies TINYINT(1) DEFAULT NULL, check_security TINYINT(1) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, added_at DATETIME NOT NULL, enabled TINYINT(1) NOT NULL, INDEX IDX_5C93B3A49395C3F3 (customer_id), PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE security (id INT AUTO_INCREMENT NOT NULL, project VARCHAR(10) DEFAULT NULL, library VARCHAR(255) NOT NULL, version VARCHAR(255) NOT NULL, state VARCHAR(20) NOT NULL, details LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C59BD5C12FB3D0EE (project), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dependencies (id INT AUTO_INCREMENT NOT NULL, project VARCHAR(10) DEFAULT NULL, library VARCHAR(255) NOT NULL, version VARCHAR(250) NOT NULL, state VARCHAR(20) NOT NULL, to_library VARCHAR(250) DEFAULT NULL, to_version VARCHAR(250) DEFAULT NULL, deprecated TINYINT(1) DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EA0F708D2FB3D0EE (project), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A49395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE security ADD CONSTRAINT FK_C59BD5C12FB3D0EE FOREIGN KEY (project) REFERENCES projects (code)');
        $this->addSql('ALTER TABLE dependencies ADD CONSTRAINT FK_EA0F708D2FB3D0EE FOREIGN KEY (project) REFERENCES projects (code)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A49395C3F3');
        $this->addSql('ALTER TABLE security DROP FOREIGN KEY FK_C59BD5C12FB3D0EE');
        $this->addSql('ALTER TABLE dependencies DROP FOREIGN KEY FK_EA0F708D2FB3D0EE');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE security');
        $this->addSql('DROP TABLE dependencies');
    }
}
