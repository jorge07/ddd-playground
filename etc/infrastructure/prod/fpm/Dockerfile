FROM jorge07/alpine-php:7.1

ENV SYMFONY_ENV prod

COPY app/app /app/app
COPY fpm/parameters.yml /app/app/config/parameters.yml
COPY app/bin /app/bin
COPY app/var /app/var
COPY app/web /app/web
COPY app/src /app/src
COPY app/vendor /app/vendor

RUN php /app/bin/console c:w
