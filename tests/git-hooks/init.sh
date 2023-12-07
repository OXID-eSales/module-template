#!/usr/bin/env bash

set -e

function setup_git_hooks()
{
  echo "Initialising git hooks..."
  git config --local core.hooksPath .git/hooks

  cp tests/git-hooks/pre-commit.sh .git/hooks/pre-commit
  chmod +x .git/hooks/pre-commit
}

setup_git_hooks