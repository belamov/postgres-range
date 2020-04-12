#!/usr/bin/env bash
docker-compose run --rm -T -e NODE_ENV=production node vuepress build docs-source