install:
	composer install

test:
	composer run-script phpcs -- --standard=PSR12 src bin tests

lint:
	composer run-script test

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover clover.xml --coverage-filter src