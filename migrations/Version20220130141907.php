<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130141907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vinyle (id INT AUTO_INCREMENT NOT NULL, style_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, illustration VARCHAR(255) NOT NULL, artiste VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, extract VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_8CD238D0BACD6074 (style_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vinyle_styles (vinyle_id INT NOT NULL, styles_id INT NOT NULL, INDEX IDX_5839BE49948AFF8F (vinyle_id), INDEX IDX_5839BE49B0A3C560 (styles_id), PRIMARY KEY(vinyle_id, styles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vinyle ADD CONSTRAINT FK_8CD238D0BACD6074 FOREIGN KEY (style_id) REFERENCES styles (id)');
        $this->addSql('ALTER TABLE vinyle_styles ADD CONSTRAINT FK_5839BE49948AFF8F FOREIGN KEY (vinyle_id) REFERENCES vinyle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vinyle_styles ADD CONSTRAINT FK_5839BE49B0A3C560 FOREIGN KEY (styles_id) REFERENCES styles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vinyle_styles DROP FOREIGN KEY FK_5839BE49948AFF8F');
        $this->addSql('DROP TABLE vinyle');
        $this->addSql('DROP TABLE vinyle_styles');
    }
}
