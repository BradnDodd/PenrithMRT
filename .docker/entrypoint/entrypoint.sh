#!/bin/sh

set -e

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- apache2-foreground "$@"
fi

FILE=/var/www/.env
if [ ! -f "$FILE" ]; then
    cp -n .env.example .env;
fi

composer install;

exec "$@"
