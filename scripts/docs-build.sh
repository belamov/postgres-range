#!/usr/bin/env bash
cd ../docker
docker-compose run --rm -T -e NODE_ENV=production node vuepress build docs-src
cd -