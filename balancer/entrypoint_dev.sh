#!/bin/bash

set -e

yarn install

exec node app.js

#Override, for testing purposes
#tail -f /dev/null