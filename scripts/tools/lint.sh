#!/usr/bin/env bash
cd "$(dirname $0)/../../" || exit 1

VENDOR="$PWD/vendor"
BIN="$VENDOR/bin"

# run PHPLint
echo ""
$BIN/phplint \
  --configuration=.phplint.yml \
  --no-interaction \
  --no-cache

if [[ $? != 0 ]]; then
  echo ""
  echo "PHPLint runned with errors, please fix."
  echo ""

  exit 3
fi

# run TLint
# clear
echo ""
$BIN/tlint lint .
if [[ $? != 0 ]]; then
  echo "TLint runned with errors, please fix."
  echo ""

  exit 3
fi

# end
echo ""
echo ""
