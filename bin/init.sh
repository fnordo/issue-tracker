#!/bin/bash
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console h:d:f:l -q
php app/console assetic:dump && php app/console cache:clear
php app/console server:run