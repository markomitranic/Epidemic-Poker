#!/bin/sh

set -e

composer install
echo "Composer install done."
exec "$@"

#Override, for testing purposes
#tail -f /dev/null