#!/usr/bin/env bash
#
# Library for testing
#

# Contains the cumulative error code over all assertions.
testStatus=0

# Assertion on commands
#
# Do assertion on commands which will increase the error code on failure.
# The error code is stored in the $testStatus variable
#
# Include this via `source lib.sh`.
# Then add a `trap 'exit $testStatus' INT TERM EXIT` to your test file
# to forward the error code to the CLI / user.
#
function assert() {
    echo "$@"
    echo ""
    "$@"

    local status=$?

    if [ $status -ne 0 ]; then
        echo "error with $@ (see above)" >&2
    fi

    testStatus+=${status}
}
