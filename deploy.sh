#!/usr/bin/env bash
cd "$(dirname $0)" || exit 1

# deploy app
bash ./scripts/app/deploy.sh "$@"
