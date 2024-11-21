up:
	@vendor/bin/sail up -d

doc:
	@vendor/bin/sail artisan ide-helper:generate --ansi
	@vendor/bin/sail artisan ide-helper:meta --ansi
	@vendor/bin/sail artisan ide-helper:models --write --ansi

refactor:
	@vendor/bin/sail bin rector --ansi

lint:
	@vendor/bin/sail bin pint -vvv

build:
	@cp .env.example .env
	@docker run --rm \
		-u "$(id -u):$(id -g)" \
		-v "$$(pwd):/var/www/html" \
		-w /var/www/html \
		laravelsail/php83-composer:latest \
		composer install --ignore-platform-reqs
	@vendor/bin/sail build --no-cache
	@vendor/bin/sail up -d
	@vendor/bin/sail artisan storage:unlink --ansi
	@vendor/bin/sail artisan storage:link --ansi
	@vendor/bin/sail artisan key:generate --ansi
	@vendor/bin/sail artisan migrate:install --ansi
	@vendor/bin/sail artisan migrate --force --ansi
	@vendor/bin/sail artisan db:seed --force --ansi