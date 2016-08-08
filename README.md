DDD Playground
===

Run with (container doc on docker hub):

    $ docker run -it -d -v $PWD:/app -p 2244:22 -p 9000:9000 jorge07/alpine-php:7-dev
    $ docker exec -it <container_name> composer install
