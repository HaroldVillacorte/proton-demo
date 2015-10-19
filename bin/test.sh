#!/usr/bin/env bash

./vendor/bin/phpunit ./Test

./vendor/bin/phpunit --coverage-text=./code-coverage.txt ./Test