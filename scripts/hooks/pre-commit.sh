#!/usr/bin/env bash
cd "$(dirname $0)/../../" || exit 1

# git pre-commit command

npm run lint
if [[ $? != 0 ]]; then
  exit 2
fi

npm run format
if [[ $? != 0 ]]; then
  exit 3
fi

git add .
