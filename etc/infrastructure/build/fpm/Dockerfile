FROM jorge07/alpine-php:7-dev

ENV SYMFONY_ENV prod

COPY app /app/app
COPY bin /app/bin
COPY var /app/var
COPY web /app/web

COPY composer.json /app
COPY composer.lock /app

RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader

COPY src /app/src

RUN php /app/bin/console c:w
