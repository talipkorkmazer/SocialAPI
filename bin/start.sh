#!/bin/bash
cd laradock

docker-compose up -d nginx mysql phpmyadmin redis redis-webui mongo mongo-webui elasticsearch php-worker workspace "$@"