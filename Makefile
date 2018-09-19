USER_ID=`id -u`

DOCKERRUN = USER_ID=${USER_ID} docker-compose run --rm
DOCKERPHP = ${DOCKERRUN} php php
DOCKERPHPSTDLN = ${DOCKERRUN} php-standalone php
DOCKERCOMPOSER = docker-compose run composer

# include .env variables
-include .env
export $(shell sed 's/=.*//' .env)

# Help
.SILENT:
.PHONY: help

help: ## Display this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# Docker
docker-up: ## start docker services
	@echo "--> Starting docker services"
	USER_ID=${USER_ID} docker-compose up -d
docker-down: ## stop and remove docker services
	@echo "--> Stopping docker services"
	USER_ID=${USER_ID} docker-compose down

reset-bdd:
	@echo "--> Removing all database and load fixtures"
	php bin/console doctrine:database:drop --force
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate --no-interaction
	php bin/console doctrine:fixtures:load --no-interaction

# Composer
composer-install: ## install composer packages (with dockerized composer)
	@echo "--> Installing composer packages"
	$(DOCKERPHP) -d memory_limit=-1 /usr/local/bin/composer install

composer-update: ## update composer packages (with dockerized composer)
	@echo "--> Installing composer packages"
	$(DOCKERPHP) -d memory_limit=-1  /usr/local/bin/composer update

composer-require: ## Require composer packages (with dockerized composer)
	@echo "--> Installing composer packages"
	$(DOCKERPHP) -d memory_limit=-1 /usr/local/bin/composer require ${ARGS}

composer-remove: ## Require composer packages (with dockerized composer)
	@echo "--> Remove composer packages"
	$(DOCKERPHP) -d memory_limit=-1 /usr/local/bin/composer remove ${ARGS}

