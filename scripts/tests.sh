#!/usr/bin/env bash
cd ../docker
docker-compose run -u 1000 --rm php composer install --no-interaction
docker-compose run --rm php vendor/bin/phpunit
cd -