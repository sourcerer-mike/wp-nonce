#!/usr/bin/env bash
#
# Library for testing
#

# Contains the cumulative error code over all assertions.
testStatus=0

# Assertion on commands
#
# Do assertion on commands which will increase the error code on failure.
# The error code is stored in the $testStatus variable.
# In addition the measured time is printed after each run
# to let you know which test takes (too) long.
#
# Include this via `source lib.sh`.
# Then add a `trap 'exit $testStatus' INT TERM EXIT` to your test file
# to forward the error code to the CLI / user.
#
function assert() {
    echo "$@"
    echo ""
    time "$@"
    echo ""

    local status=$?

    if [ $status -ne 0 ]; then
        echo "error with $@ (see above)" >&2
    fi

    testStatus+=${status}
}

# setup phpcs
vendor/bin/phpcs --config-set installed_paths vendor/wp-coding-standards/wpcs/