install:
	composer install

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests

test:
	composer run-script test

test-coverage:
	XDEBUG_MODE=coverage composer run-script test -- --coverage-clover build/logs/clover.xml --coverage-filter src/