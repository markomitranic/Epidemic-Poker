#!/bin/sh

# Load all .env vars
set -a
[ -f .env ] && . ./.env.dist
[ -f .env ] && . ./.env
set +a

# Pre-Build all the non-public container images.
docker build ./frontend -t epidemicpoker_frontend --target ${ENV}
# Run the thing.
docker-compose -f docker-compose.yml -f docker-compose-dev.yml down
docker-compose -f docker-compose.yml -f docker-compose-dev.yml build
docker-compose -f docker-compose.yml -f docker-compose-dev.yml up --remove-orphans
