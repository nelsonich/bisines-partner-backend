#!/usr/bin/env bash
cd "$(dirname $0)/../../" || exit 1

ARGS="$*"

function is_option_passed() {
  local OPTION_NAME="$1"

  if [[ "$ARGS" == *$OPTION_NAME* ]]; then
    return 1
  else
    return 0
  fi
}

function pad_dots() {
  local MESSAGE="$1"

  local LENGTH_MSG=${#MESSAGE}
  local LENGTH_DOT=$((60 - $LENGTH_MSG))

  for INDEX in $(seq $LENGTH_DOT); do
    echo -en "."
  done
}

function exit_fail_or_done() {
  local EXIT_CODE="$1"
  local ERROR_CODE="$2"

  if [[ $? != 0 ]]; then
    echo "FAIL"
    exit $1
  fi

  echo "DONE"
}

function print_and_skip_if() {
  local CHECK_SKIP="$1"
  local MESSAGE="$2"

  echo -n " * $MESSAGE $(pad_dots "$MESSAGE") "

  is_option_passed "$CHECK_SKIP"

  if [[ $? -ne 0 ]]; then
    echo "SKIP"
    return 1
  else
    return 0
  fi
}

# print welcome message
sudo echo -n ''

is_option_passed "--no:initial-clear"
if [[ $? -eq 0 ]]; then
  clear
  echo ""
fi

echo ""
echo " ==================================================================="
echo " ======               DEPLOYMENT SCRIPT STARTED               ======"
echo " ==================================================================="
echo ""

sleep 1s

# pull without running git hooks
print_and_skip_if "--no:gi-pull" "Pulling latest version from Git repository"
if [[ $? -eq 0 ]]; then
  mkdir -p .githooks > /dev/null 2>&1
  mv .git/hooks/* .githooks > /dev/null 2>&1
  git reset --hard --quiet > /dev/null 2>&1
  git pull --quiet > /dev/null 2>&1
  PULL_EXIT_CODE=$?
  mv .githooks/* .git/hooks/ > /dev/null 2>&1
  rm -rf .githooks > /dev/null 2>&1

  exit_fail_or_done $PULL_EXIT_CODE 10001
fi

# update permissions
print_and_skip_if "--no:permissions" "Updating permissions"
if [[ $? -eq 0 ]]; then
  sudo bash ./scripts/app/update-permissions.sh > /dev/null 2>&1
  exit_fail_or_done $? 10002
fi

# clearing config cache
print_and_skip_if "--no:cache-clear" "Clearing config cache"
if [[ $? -eq 0 ]]; then
  php artisan config:clear > /dev/null 2>&1
  exit_fail_or_done $? 20001
fi

# clearing data cache
print_and_skip_if "--no:cache-clear" "Clearing data cache"
if [[ $? -eq 0 ]]; then
  php artisan cache:clear > /dev/null 2>&1
  exit_fail_or_done $? 20002
fi

# clearing route cache
print_and_skip_if "--no:db-seed" "Clearing route cache"
if [[ $? -eq 0 ]]; then
  php artisan route:clear > /dev/null 2>&1
  exit_fail_or_done $? 20003
fi

# clearing view cache
print_and_skip_if "--no:cache-clear" "Clearing view cache"
if [[ $? -eq 0 ]]; then
  php artisan view:clear > /dev/null 2>&1
  exit_fail_or_done $? 20004
fi

# clearing event cache
print_and_skip_if "--no:cache-clear" "Clearing event cache"
if [[ $? -eq 0 ]]; then
  php artisan event:clear > /dev/null 2>&1
  exit_fail_or_done $? 20005
fi

# clearing node modules cache
print_and_skip_if "--no:cache-clear" "Clearing node modules cache"
if [[ $? -eq 0 ]]; then
  npm cache clean --force > /dev/null 2>&1
  exit_fail_or_done $? 20006
fi

# clearing composer cache
print_and_skip_if "--no:cache-clear" "Clearing composer cache"
if [[ $? -eq 0 ]]; then
  composer clear-cache --no-interaction > /dev/null 2>&1
  exit_fail_or_done $? 20007
fi

# update composer packages
print_and_skip_if "--no:update-composer" "Updating composer packages"
if [[ $? -eq 0 ]]; then
  composer install --no-interaction --ignore-platform-reqs > /dev/null 2>&1
  exit_fail_or_done $? 30001
fi

# update composer packages
print_and_skip_if "--no:update-composer" "Dumping composer packages"
if [[ $? -eq 0 ]]; then
  composer dump --no-interaction --ignore-platform-reqs > /dev/null 2>&1
  exit_fail_or_done $? 30002
fi

# update node modules
print_and_skip_if "--no:update-node-modules" "Updating node modules"
if [[ $? -eq 0 ]]; then
  npm install > /dev/null 2>&1
  exit_fail_or_done $? 30003
fi

# migrating database
print_and_skip_if "--no:db-migrate" "Migrating database"
if [[ $? -eq 0 ]]; then
  php artisan migrate --force > /dev/null 2>&1
  exit_fail_or_done $? 40001
fi

# build config cache
print_and_skip_if "--no:cache-build" "Building config cache"
if [[ $? -eq 0 ]]; then
  php artisan config:cache > /dev/null 2>&1
  exit_fail_or_done $? 50001
fi

# build route cache
print_and_skip_if "--no:cache-build" "Building route cache"
if [[ $? -eq 0 ]]; then
  php artisan route:cache > /dev/null 2>&1
  if [[ $(php artisan route:list | wc -l) -lt 20 ]]; then
    php artisan route:cache > /dev/null 2>&1
  fi
  exit_fail_or_done $? 50003
fi

# build view cache
print_and_skip_if "--no:cache-build" "Building view cache"
if [[ $? -eq 0 ]]; then
  php artisan view:cache > /dev/null 2>&1
  exit_fail_or_done $? 50004
fi

# build event cache
print_and_skip_if "--no:cache-build" "Building event cache"
if [[ $? -eq 0 ]]; then
  php artisan event:cache > /dev/null 2>&1
  exit_fail_or_done $? 50005
fi

# print empty lines
echo ""
echo ""
echo ""
