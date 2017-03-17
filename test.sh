#!/bin/bash

clear;

# PHPUnit tests
./vendor/bin/phpunit --config tests/phpunit/phpunit.xml;
PHPUNIT_RETURN_CODE=$?

# PHPSpec tests
./vendor/bin/phpspec run --config tests/phpspec/phpspec.yml;
PHPSPEC_RETURN_CODE=$?

# Behat service-level tests
./vendor/bin/behat -c tests/behat/behat.yml --suite servicelevel;
BEHAT_SERVICELEVEL_RETURN_CODE=$?

# Behat application-level tests
./vendor/bin/behat -c tests/behat/behat.yml --suite applicationlevel;
BEHAT_APPLICATIONLEVEL_RETURN_CODE=$?

# Start webserver, run Behat tests, stop webserver
pushd public/
php -S localhost:8001 &> /dev/null &
WEBSERVER_PROCESS_ID=$!;
popd
./vendor/bin/behat -c tests/behat/behat.yml --suite httplevel;
BEHAT_HTTPLEVEL_RETURN_CODE=$?
kill -9 $WEBSERVER_PROCESS_ID;

# Print results so you don't have to scroll
echo;
echo -n 'PHPUnit return code:                 ';
echo $PHPUNIT_RETURN_CODE;

echo -n 'PHPSpec return code:                 ';
echo $PHPSPEC_RETURN_CODE;

echo -n 'Behat service-level return code:     ';
echo $BEHAT_SERVICELEVEL_RETURN_CODE;

echo -n 'Behat HTTP-level return code:        ';
echo $BEHAT_HTTPLEVEL_RETURN_CODE;

echo -n 'Behat application-level return code: ';
echo $BEHAT_APPLICATIONLEVEL_RETURN_CODE;

# Work out an exit code, and exit
OVERALL_EXIT_CODE=$((PHPUNIT_RETURN_CODE + PHPSPEC_RETURN_CODE + BEHAT_SERVICELEVEL_RETURN_CODE + BEHAT_HTTPLEVEL_RETURN_CODE))
exit $OVERALL_EXIT_CODE;
