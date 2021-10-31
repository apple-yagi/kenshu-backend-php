<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUsersTable extends AbstractMigration
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
			CREATE TABLE IF NOT EXISTS users (
  			id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  			name VARCHAR(15) NOT NULL UNIQUE,
  			password_hash TEXT NOT NULL,
  			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  			updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  			PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
    );
  }
}
