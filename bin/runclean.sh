#!/bin/bash

SCRIPT_PATH=$(dirname ${BASH_SOURCE[0]})
cd $SCRIPT_PATH/.. || exit

echo 'This script will remove all example implementations'


# clean metadata.php
perl -pwe '
  if (/\s*extend.*/) {
      exit;
  } else {
        open ($out, ">>", "metadata.php.new") or die "Could not open file $!";
        select $out;
     }
  ' ./metadata.php
echo '];' >> ./metadata.php.new
mv ./metadata.php.new ./metadata.php

#clean out migrations
rm -rf ./migration/data/*
touch ./migration/data/.gitkeep

#remove views and translations
rm -rf ./out
rm -rf ./translations
rm -rf ./views
rm -rf ./services.yaml

#clean out module source code
rm -rf ./src/*
touch ./src/.gitignore

#clean out tests
mv ./tests/Codeception/Acceptance/ExampleCest.php ./tests/Codeception/Acceptance/ExampleCest.bak
rm -rf ./tests/Codeception/Acceptance/*.php
mv ./tests/Codeception/Acceptance/ExampleCest.bak ./tests/Codeception/Acceptance/ExampleCest.php

mv ./tests/Integration/ExampleTest.php ./tests/ExampleTest.bak
rm -rf ./tests/Integration/*
mv ./tests/ExampleTest.bak ./tests/Integration/ExampleTest.php

mv ./tests/Unit/ExampleTest.php ./tests/ExampleTest.bak
rm -rf ./tests/Unit/*
mv ./tests/ExampleTest.bak ./tests/Unit/ExampleTest.php

perl -pwe '
  open ($out, ">>", "tmp.yml") or die "Could not open file $!";
  if (/\s*paths:.*/) {
       print  "        paths: \"Application/views/flow,Application/views/admin\" #  ";
  } else {
        select $out;
     }
  ' ./tests/Codeception/acceptance.suite.yml
mv ./tmp.yml ./tests/Codeception/acceptance.suite.yml

echo
echo 'Cleanup done. Now it is your turn to fill the module with code.'