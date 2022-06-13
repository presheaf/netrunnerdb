#!/bin/bash

# WIP - idea is for this to be run _once_ when initializing the database
# to add cards, prefer bash-ing into the container and doing the update thing?

# php bin/console doctrine:database:create  # handled by the mysql container
php bin/console doctrine:schema:update --force

# -f = yes to all
php bin/console app:import:std -f /nr_data_repo_json/
