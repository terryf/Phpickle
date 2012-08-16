
tests:
	cd tests; phpunit --coverage-html coverage .

gen:
	php -r "include('phpickle_ops_generator.php'); make_defaults();"

.PHONY: tests