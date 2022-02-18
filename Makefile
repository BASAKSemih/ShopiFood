twig:
	php bin/console lint:twig templates
	vendor/bin/twigcs templates
	vendor/bin/twigcs templates

phpmd:
	vendor/bin/phpmd src/ text .phpmd.xml

insights:
	vendor/bin/phpinsights --no-interaction

phpstan:
	php vendor/bin/phpstan analyse -c phpstan.neon src --no-progress

metrics:
	php ./vendor/bin/phpmetrics --report-html=myreport ./src