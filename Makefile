init: docker-down-clear docker-pull docker-build composer-install docker-up

docker-down-clear:
	docker compose down -v --remove-orphans

docker-pull:
	docker compose pull

docker-build:
	docker compose build --pull

docker-up:
	docker compose up -d

bash:
	docker compose run --rm php-cli bash

cs-fix:
	docker compose run --rm php-cli vendor/bin/php-cs-fixer fix

psalm:
	docker compose run --rm php-cli vendor/bin/psalm

tests:
	docker compose run --rm php-cli bin/console --env=test doctrine:database:drop --if-exists --force
	docker compose run --rm php-cli bin/console --env=test doctrine:database:create -q
	docker compose run --rm php-cli bin/console --env=test doctrine:migrations:migrate -q
	docker compose run --rm php-cli bin/console --env=test doctrine:fixtures:load -q
	docker compose run --rm php-cli bin/phpunit

composer-install:
	docker compose run --rm php-cli composer install
