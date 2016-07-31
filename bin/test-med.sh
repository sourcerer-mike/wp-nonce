#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Assert all small tests
# will trap $testStatus as exit code.
source $DIR/test-min.sh

