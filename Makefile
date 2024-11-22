up:
	@vendor/bin/sail up -d
	@vendor/bin/sail npm install
	@vendor/bin/sail npm run dev

doc:
	@vendor/bin/sail artisan ide-helper:generate --ansi
	@vendor/bin/sail artisan ide-helper:meta --ansi
	@vendor/bin/sail artisan ide-helper:models --write --ansi

refactor:
	@vendor/bin/sail bin rector --ansi

lint:
	@vendor/bin/sail bin pint -vvv
	@vendor/bin/sail npm run lint:fix

format:
	@vendor/bin/sail npm run format:fix

frontend-build:
	@vendor/bin/sail npm run build

test:
	@vendor/bin/sail artisan test --ansi
	@vendor/bin/sail npm run test

pre-commit:
	@make doc
	@make refactor
	@make lint
	@make format
	@make frontend-build
	@make test
	@echo "All checks passed. Ready to commit."

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
	@vendor/bin/sail npm install
	@vendor/bin/sail artisan storage:unlink --ansi
	@vendor/bin/sail artisan storage:link --ansi
	@vendor/bin/sail artisan key:generate --ansi
	@vendor/bin/sail artisan migrate:install --ansi
	@vendor/bin/sail artisan migrate --force --ansi
	@vendor/bin/sail artisan db:seed --force --ansi
