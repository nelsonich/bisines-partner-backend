#!/usr/bin/env bash
cd "$(dirname $0)/../../" || exit 1

function change_mode() {
  CHANGE_MODE=$1
  CHANGE_PATH=$2

  if [[ -d "$CHANGE_PATH" ]]; then
    echo "Changing permission [$CHANGE_MODE -> $CURRENT_MODE, d]: $CHANGE_PATH"
    sudo chmod -R $CHANGE_MODE "$CHANGE_PATH"
  fi

  if [[ -f "$CHANGE_PATH" ]]; then
    echo "Changing permission [$CURRENT_MODE -> $CHANGE_MODE, f]: $CHANGE_PATH"
    sudo chmod $CHANGE_MODE "$CHANGE_PATH"
  fi
}

MACHINE="unknown"
case "$(uname -s)" in
  Linux*) MACHINE="Linux" ;;
  Darwin*) MACHINE="macOS" ;;
  CYGWIN*) MACHINE="Win Cygwin" ;;
  MINGW*) MACHINE="Windows MinGw" ;;
  *) MACHINE="unknown" ;;
esac

if [[ "Linux" == "$MACHINE" || "macOS" == "$MACHINE" ]]; then
  if [[ "$(command -v sudo)" != "" ]]; then
    CHMOD_FILES=(
      "777:./storage/logs"
      "777:./storage/framework"
      "777:./storage/app"
    )

    for CHMOD_FILE in "${CHMOD_FILES[@]}"; do
      IFS=':' read -ra CHMOD_FILE_OPTIONS <<< "$CHMOD_FILE"
      F_MODE="${CHMOD_FILE_OPTIONS[0]}"
      F_PATH="${CHMOD_FILE_OPTIONS[1]}"

      change_mode "$F_MODE" "$F_PATH"
    done
  else
    echo "Sorry, we can't find sudo for file/directory changing permission."
  fi
else
  echo "Sorry, for Windows we can't change files or directories permission."
fi
