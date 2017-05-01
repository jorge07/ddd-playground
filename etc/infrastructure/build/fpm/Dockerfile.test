FROM jorge07/alpine-php:7.1-dev

COPY app /app/app
COPY var /app/var
COPY web /app/web
COPY composer.json /app
COPY composer.lock /app

RUN composer install --no-ansi --no-interaction --no-progress --optimize-autoloader

COPY bin /app/bin
COPY src /app/src
COPY tests /app/tests
COPY phpunit.xml.dist /app/phpunit.xml.dist
COPY behat.yml /app/behat.yml
COPY build.xml /app/build.xml
COPY depfile.yml /app

RUN php /app/bin/console c:c
