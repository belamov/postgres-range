#!/usr/bin/env bash
cd ../docker
docker-compose run --rm -T node vuepress dev docs-src
cd -