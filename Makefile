twig:
	php bin/console lint:twig templates
	vendor/bin/twigcs templates

phpmd:
	vendor/bin/phpmd src/ text .phpmd.xml

insights:
	vendor/bin/phpinsights --no-interaction

phpcpd:
	vendor/bin/phpcpd src/

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon src --no-progress

fix:
	vendor/bin/php-cs-fixer fix

metrics:
	php ./vendor/bin/phpmetrics --report-html=myreport ./src

composer:
	composer valid

container:
	symfony console lint:container

yaml:
	symfony console lint:yaml config

doctrine:
	symfony console doctrine:schema:validate
	symfony console doctrine:mapping:info

analyse:
	make composer
	make container
	make yaml
	make twig
	make phpmd
	make phpcpd
	make insights
	make phpstan

test:
	composer prepare-test
	vendor/bin/phpunit