#!/usr/bin/env bash
cd ../docker
docker-compose run --rm php vendor/bin/phpunit
cd -