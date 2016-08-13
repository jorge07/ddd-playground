DDD Playground
===

Quick env: [See doc first](https://hub.docker.com/r/jorge07/alpine-php/)

    $ docker run -it -d -v $PWD:/app -p 2244:22 -p 9000:9000 jorge07/alpine-php:7-dev
    $ docker exec -it <container_name> composer install

OR

    $ docker run -it -rm -v $PWD:/app jorge07/alpine-php:7-dev composer install
    $ docker-compose -f etc/infrastructure/dev/docker-compose.yml up -d

Test the workflow and build image:

    $ cd etc/infrastructure/
    $ ./deploy.sh
