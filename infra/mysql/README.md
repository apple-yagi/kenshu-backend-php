# 各 Table の構造一覧

# users

| Field         | Type             | Null | Key | Default           | Extra                       |
| :------------ | :--------------- | :--- | --- | ----------------- | --------------------------- |
| id            | int(10) unsigned | NO   | PRI | NULL              | auto_increment              |
| name          | text             | NO   |     | NULL              |                             |
| password_hash | text             | NO   |     | NULL              |                             |
| created_at    | timestamp        | NO   |     | CURRENT_TIMESTAMP |                             |
| updated_at    | timestamp        | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |

# articles

| Field        | Type             | Null | Key | Default           | Extra                       |
| :----------- | :--------------- | :--- | --- | ----------------- | --------------------------- |
| id           | int(10) unsigned | NO   | PRI | NULL              | auto_increment              |
| user_id      | int(10) unsigned | NO   | MUL | NULL              |                             |
| thumbnail_id | int(10) unsigned | NO   |     | NULL              |                             |
| title        | text             | NO   |     | NULL              |                             |
| body         | text             | YES  |     | NULL              |                             |
| created_at   | timestamp        | NO   |     | CURRENT_TIMESTAMP |                             |
| updated_at   | timestamp        | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |

# photos

| Field      | Type             | Null | Key | Default           | Extra                       |
| :--------- | :--------------- | :--- | --- | ----------------- | --------------------------- |
| id         | int(10) unsigned | NO   | PRI | NULL              | auto_increment              |
| article_id | int(10) unsigned | NO   | MUL | NULL              |                             |
| url        | text             | NO   |     | NULL              |                             |
| created_at | timestamp        | NO   |     | CURRENT_TIMESTAMP |                             |
| updated_at | timestamp        | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |

# tags

| Field      | Type             | Null | Key | Default           | Extra                       |
| :--------- | :--------------- | :--- | --- | ----------------- | --------------------------- |
| id         | int(10) unsigned | NO   | PRI | NULL              | auto_increment              |
| name       | text             | NO   |     | NULL              |                             |
| created_at | timestamp        | NO   |     | CURRENT_TIMESTAMP |                             |
| updated_at | timestamp        | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |

# articles_tags

| Field      | Type             | Null | Key | Default | Extra          |
| :--------- | :--------------- | :--- | --- | ------- | -------------- |
| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
| article_id | int(10) unsigned | NO   | MUL | NULL    |                |
| tag_id     | int(10) unsigned | NO   | MUL | NULL    |                |
