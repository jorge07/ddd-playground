FROM jorge07/alpine-php:7.1-dev

ENV SYMFONY_ENV prod

COPY app /app/app
COPY etc/infrastructure/prod/fpm/parameters.yml /app/app/config/parameters.yml
COPY bin /app/bin
COPY var /app/var
COPY web /app/web

COPY composer.json /app
COPY composer.lock /app

RUN composer install --no-ansi --no-scripts --no-dev --no-interaction --no-progress --optimize-autoloader

COPY src /app/src

RUN composer run-script post-install-cmd
