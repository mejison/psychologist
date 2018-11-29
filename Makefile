DB_DATABASE=test
DB_USERNAME=test
DB_PASSWORD=test
CACHE_DRIVER=array
MAIL_HOST=smtp.gigahost.dk
MAIL_PORT=587
MAIL_USERNAME=info@specialistuddannelse.dk
MAIL_PASSWORD=secret
MAIL_ENCRYPTION=tls

.PHONY: config deploy-local deploy-dev deploy-golive deploy-app

config:
	@if [ -f ./.env ]; then rm ./.env; fi
	@cp ./.env.example ./.env
	@if [ "$(shell uname)" = 'Linux' ]; then \
		sed -i "s/\(DB_DATABASE=\)homestead/\1${DB_DATABASE}/" .env; \
		sed -i "s/\(DB_USERNAME=\)homestead/\1${DB_USERNAME}/" .env; \
		sed -i "s/\(DB_PASSWORD=\)secret/\1${DB_PASSWORD}/" .env; \
		sed -i "s/\(CACHE_DRIVER=\)file/\1${CACHE_DRIVER}/" .env; \
		sed -i "s/\(MAIL_HOST=\)mailtrap.io/\1${MAIL_HOST}/" .env; \
		sed -i "s/\(MAIL_PORT=\)2525/\1${MAIL_PORT}/" .env; \
		sed -i "s/\(MAIL_USERNAME=\)null/\1${MAIL_USERNAME}/" .env; \
		sed -i "s/\(MAIL_PASSWORD=\)null/\1${MAIL_PASSWORD}/" .env; \
		sed -i "s/\(MAIL_ENCRYPTION=\)null/\1${MAIL_ENCRYPTION}/" .env; \
  elif [ "$(shell uname)" = 'Darwin' ]; then \
		sed -i.bak "s/\(DB_DATABASE=\)homestead/\1${DB_DATABASE}/" .env && rm .env.bak; \
		sed -i.bak "s/\(DB_USERNAME=\)homestead/\1${DB_USERNAME}/" .env && rm .env.bak; \
		sed -i.bak "s/\(DB_PASSWORD=\)secret/\1${DB_PASSWORD}/" .env && rm .env.bak; \
		sed -i.bak "s/\(CACHE_DRIVER=\)file/\1${CACHE_DRIVER}/" .env && rm .env.bak; \
		sed -i.bak "s/\(MAIL_HOST=\)mailtrap.io/\1${MAIL_HOST}/" .env && rm .env.bak; \
		sed -i.bak "s/\(MAIL_PORT=\)2525/\1${MAIL_PORT}/" .env && rm .env.bak; \
		sed -i.bak "s/\(MAIL_USERNAME=\)null/\1${MAIL_USERNAME}/" .env && rm .env.bak; \
		sed -i.bak "s/\(MAIL_PASSWORD=\)null/\1${MAIL_PASSWORD}/" .env && rm .env.bak; \
		sed -i.bak "s/\(MAIL_ENCRYPTION=\)null/\1${MAIL_ENCRYPTION}/" .env && rm .env.bak; \
	fi

deploy-local: config
	@if [ ! -d ./storage/framework/views ]; then mkdir ./storage/framework/views; fi
	@if [ ! -d ./storage/framework/sessions ]; then mkdir ./storage/framework/sessions; fi
	@if [ -f artisan ]; then ./artisan migrate:reset; fi
	@if [ -f artisan ]; then ./artisan migrate; fi
	@if [ -f artisan ]; then ./artisan db:seed; fi
	@if [ -f artisan ]; then ./artisan key:generate; fi
	@if [ -f artisan ]; then ./artisan config:clear; fi
	@if [ -f artisan ]; then ./artisan cache:clear; fi
	@if [ -f artisan ]; then ./artisan view:clear; fi

deploy-dev: config
	@if [ ! -d ./storage/framework/views ]; then mkdir ./storage/framework/views; fi
	@if [ ! -d ./storage/framework/sessions ]; then mkdir ./storage/framework/sessions; fi
	@composer install --no-interaction --prefer-dist --optimize-autoloader
	@echo "" | sudo -S service php7.1-fpm reload
	@sed -i "s/\(APP_ENV=\)local/\1dev/" .env
	@sed -i "s/\(APP_DEBUG=\)true/\1true/" .env
	@sed -i "s/\(APP_LOG_LEVEL=\)debug/\1debug/" .env
	@sed -i "s/\(APP_URL=\)http:\/\/localhost/\1http:\/\/dev.specialistuddannelse.dk/" .env
	@if [ -f artisan ]; then ./artisan migrate:reset; fi
	@if [ -f artisan ]; then ./artisan migrate; fi
	@if [ -f artisan ]; then ./artisan db:seed; fi
	@if [ -f artisan ]; then ./artisan key:generate; fi
	@if [ -f artisan ]; then ./artisan config:clear; fi
	@if [ -f artisan ]; then ./artisan cache:clear; fi
	@if [ -f artisan ]; then ./artisan view:clear; fi

deploy-golive: config
	@if [ ! -d ./storage/framework/views ]; then mkdir ./storage/framework/views; fi
	@if [ ! -d ./storage/framework/sessions ]; then mkdir ./storage/framework/sessions; fi
	@composer install --no-interaction --prefer-dist --optimize-autoloader
	@echo "" | sudo -S service php7.1-fpm reload
	@sed -i "s/\(APP_ENV=\)local/\1staging/" .env
	@sed -i "s/\(APP_DEBUG=\)true/\1false/" .env
	@sed -i "s/\(APP_LOG_LEVEL=\)debug/\1error/" .env
	@sed -i "s/\(APP_URL=\)http:\/\/localhost/\1http:\/\/golive.specialistuddannelse.dk/" .env
	@if [ -f artisan ]; then ./artisan migrate:reset; fi
	@if [ -f artisan ]; then ./artisan migrate; fi
	@if [ -f artisan ]; then ./artisan db:seed; fi
	@if [ -f artisan ]; then ./artisan key:generate; fi
	@if [ -f artisan ]; then ./artisan config:clear; fi
	@if [ -f artisan ]; then ./artisan cache:clear; fi
	@if [ -f artisan ]; then ./artisan view:clear; fi

deploy-app: config
	@if [ ! -d ./storage/framework/views ]; then mkdir ./storage/framework/views; fi
	@if [ ! -d ./storage/framework/sessions ]; then mkdir ./storage/framework/sessions; fi
	@composer install --no-interaction --prefer-dist --optimize-autoloader
	@sed -i "s/\(APP_ENV=\)local/\1production/" .env
	@sed -i "s/\(APP_DEBUG=\)true/\1false/" .env
	@sed -i "s/\(APP_LOG_LEVEL=\)debug/\1error/" .env
	@sed -i "s/\(APP_URL=\)http:\/\/localhost/\1http:\/\/app.specialistuddannelse.dk/" .env
	@if [ -f artisan ]; then ./artisan migrate; fi
	@if [ -f artisan ]; then ./artisan key:generate; fi
	@if [ -f artisan ]; then ./artisan config:clear; fi
	@if [ -f artisan ]; then ./artisan cache:clear; fi
	@if [ -f artisan ]; then ./artisan view:clear; fi
