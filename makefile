init:
	make build && make up && make composer-install && mkdir -p htdocs/public/uploads
build:
	docker-compose build
up:
	docker-compose up -d
down:
	docker-compose down
kenshu-php:
	docker exec -it kenshu-php bash
kenshu-mysql:
	docker exec -it kenshu-mysql bash
composer-install:
	docker exec kenshu-php composer install
dump-autoload:
	docker exec kenshu-php composer dump-autoload
migrate:
	docker exec kenshu-php vendor/bin/phinx migrate -e development