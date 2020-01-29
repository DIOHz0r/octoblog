<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200129030109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nombre VARCHAR(200) NOT NULL, apellido VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_2265B05DE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE puntaje ADD CONSTRAINT FK_36BDA2D4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE puntaje ADD CONSTRAINT FK_36BDA2DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D14D45BBE FOREIGN KEY (autor_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E7024B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702613CEC58 FOREIGN KEY (padre_id) REFERENCES comentario (id)');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E70214D45BBE FOREIGN KEY (autor_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE puntaje DROP FOREIGN KEY FK_36BDA2DDB38439E');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D14D45BBE');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E70214D45BBE');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E7024B89032C');
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702613CEC58');
        $this->addSql('ALTER TABLE puntaje DROP FOREIGN KEY FK_36BDA2D4B89032C');
    }
}
