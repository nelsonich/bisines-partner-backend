#!/usr/bin/env bash
cd "$(dirname $0)/../../" || exit 1

# git post-pull command

sudo bash ./scripts/app/deploy.sh
