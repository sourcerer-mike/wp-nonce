#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Load helper
source $DIR/lib.sh

trap 'exit $testStatus' INT TERM EXIT

assert composer validate --strict