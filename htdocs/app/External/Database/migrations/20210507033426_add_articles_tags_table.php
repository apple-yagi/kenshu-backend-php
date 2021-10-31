<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddArticlesTagsTable extends AbstractMigration
{
  /**
   * Change Method.
   *
   * Write your reversible migrations using this method.
   *
   * More information on writing migrations is available here:
   * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
   *
   * Remember to call "create()" or "update()" and NOT "save()" when working
   * with the Table class.
   */
  public function change(): void
  {
    $this->execute(
      "
      CREATE TABLE IF NOT EXISTS articles_tags (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        article_id INT UNSIGNED NOT NULL,
        tag_id INT UNSIGNED NOT NULL,
      
        PRIMARY KEY (id),
        
        FOREIGN KEY (article_id)
          REFERENCES articles (id)
          ON DELETE CASCADE,

        FOREIGN KEY (tag_id)
          REFERENCES tags (id)
          ON DELETE CASCADE
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
    );
  }
}
