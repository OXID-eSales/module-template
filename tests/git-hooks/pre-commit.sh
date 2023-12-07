#!/bin/bash

docker compose exec -T \
--workdir /var/www/dev-packages/moduletemplate \
        php composer static
