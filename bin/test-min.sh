#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Load helper
source $DIR/lib.sh

trap 'exit $testStatus' INT TERM EXIT

# This need to be a proper composer package.
assert composer validate --strict

# This shall have a README.md
assert stat -c %a README.md

# Assert WordPress coding standards (almost)
assert vendor/bin/phpcs -v --standard=etc/phpcs.xml lib