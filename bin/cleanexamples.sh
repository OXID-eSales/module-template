#!/bin/bash

SCRIPT_PATH=$(dirname ${BASH_SOURCE[0]})
cd $SCRIPT_PATH/.. || exit

echo 'This script will remove all example implementations'


# clean metadata.php
perl -0777pi\
  -e 's#(^.*?extend.*?=>)(.*?)(\];.*?)$#\1 \[\],\n\3#gs'\
  metadata.php

#clean out migrations
rm -rf ./migration/data/*
touch ./migration/data/.gitkeep

#remove views and translations
rm -rf ./out
rm -rf ./translations
rm -rf ./views

#cleanup services.yaml
perl -0777pi\
  -e 's#(^.*?autowire: true)(.*?)$#\1#gs'\
  services.yaml

#clean out module source code
rm -rf ./src/*
touch ./src/.gitkeep

#clean out tests
mv ./tests/Codeception/Acceptance/_bootstrap.php ./tests/Codeception/Acceptance/_bootstrap.bak
rm -rf ./tests/Codeception/Acceptance/*.php
mv ./tests/Codeception/Acceptance/_bootstrap.bak ./tests/Codeception/Acceptance/_bootstrap.php

mv ./tests/Integration/ExampleTest.php ./tests/ExampleTest.bak
rm -rf ./tests/Integration/*
mv ./tests/ExampleTest.bak ./tests/Integration/ExampleTest.php

rm -rf ./tests/Unit/*

perl -pi\
  -e 's#paths:.*#paths: "Application/views/flow/translations,Application/views/admin"#g;'\
  ./tests/Codeception/Acceptance.suite.yml

echo
echo 'Cleanup done. Now it is your turn to fill the module with code.'
