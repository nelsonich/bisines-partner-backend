#!/usr/bin/env bash
cd "$(dirname $0)/../../" || exit 1

## --------------------------------------------------------------------------
## check .env file exists
if [[ ! -f ".env" ]]; then
  echo "Please make .env file and set configs before starting."
  exit 2
fi

## --------------------------------------------------------------------------
## install nodejs required packages
if [[ ! -d "node_modules" ]]; then
  npm install
fi

## --------------------------------------------------------------------------
## install laravel required packages
if [[ "$(command -v composer)" == "" ]]; then
  echo "Please install composer to continue."
  exit 3
fi
composer install --no-interaction

## --------------------------------------------------------------------------
## initiate project
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force

## --------------------------------------------------------------------------
## make symlink of storage
php artisan storage:link

## --------------------------------------------------------------------------
## update permissions
bash ./scripts/app/update-permissions.sh
