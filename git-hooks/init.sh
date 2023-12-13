#!/usr/bin/env bash

set -e

function setup_git_hooks()
{
  echo "Initialising git hooks..."

  MODULE_PATH=$(git rev-parse --show-toplevel)
  PRE_COMMIT_HOOK_FILE_PATH=$MODULE_PATH/.git/hooks/pre-commit

  git config --local core.hooksPath .git/hooks
  echo "Add hook command to pre-commit file $PRE_COMMIT_HOOK_FILE_PATH"

  if ! [ -f "${PRE_COMMIT_HOOK_FILE_PATH}" ];then
    echo $'#!/bin/bash\n' >> $PRE_COMMIT_HOOK_FILE_PATH
  fi

  COMPOSER_STATIC_COMMAND="docker compose exec -T --workdir $MODULE_PATH php composer static"

  if grep -q "$COMPOSER_STATIC_COMMAND" "$PRE_COMMIT_HOOK_FILE_PATH"; then
    echo "Command has already been added"
    return
  fi

  echo "$COMPOSER_STATIC_COMMAND" >> $PRE_COMMIT_HOOK_FILE_PATH
  chmod +x $PRE_COMMIT_HOOK_FILE_PATH
}

setup_git_hooks