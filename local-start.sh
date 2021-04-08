#!/bin/sh
set -e
# This script is a quick way to stop, rebuild, and restart the docker containers

GREEN='\033[1;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo $(date -u) "==== local-start.sh script ===="

echo $(date -u) "Bringing down running containers..."
docker-compose -f docker-compose.local.yml down
echo $(date -u) "${GREEN}Successfully stopped containers.${NC}"

echo $(date -u) "Building development images and starting containers..."
docker-compose -f docker-compose.local.yml up --build
