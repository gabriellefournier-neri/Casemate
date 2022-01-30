<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130153628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vinyle_styles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vinyle_styles (vinyle_id INT NOT NULL, styles_id INT NOT NULL, INDEX IDX_5839BE49948AFF8F (vinyle_id), INDEX IDX_5839BE49B0A3C560 (styles_id), PRIMARY KEY(vinyle_id, styles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE vinyle_styles ADD CONSTRAINT FK_5839BE49948AFF8F FOREIGN KEY (vinyle_id) REFERENCES vinyle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vinyle_styles ADD CONSTRAINT FK_5839BE49B0A3C560 FOREIGN KEY (styles_id) REFERENCES styles (id) ON DELETE CASCADE');
    }
}
