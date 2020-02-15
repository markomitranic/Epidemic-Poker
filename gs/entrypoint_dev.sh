#!/bin/sh

set -e

composer install
echo "[Composer install done] Starting a new GS at port 8000."

exec "$@"

#Override, for testing purposes
#tail -f /dev/null