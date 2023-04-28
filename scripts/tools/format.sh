#!/usr/bin/env bash
cd "$(dirname $0)/../../" || exit 1

function pretify() {
  local DIR="$1"
  local FILES="$2"

  "$PWD/node_modules/.bin/prettier" \
    "$DIR" \
    --loglevel error \
    --write "$FILES"
}

pretify . "**/*.+(json|js)"
if [[ $? != 0 ]]; then
  exit 2
fi

pretify . "**/*.+(php|json|js|css|scss)"
if [[ $? != 0 ]]; then
  exit 3
fi
