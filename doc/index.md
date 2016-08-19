DDD Playground
===============

This repo its a REST API built following more or less DDD and using few useful packages like:


- `ramsey/uuid`

- `snc/redis-bundle`

- `nelmio/api-doc-bundle` 

- `friendsofsymfony/rest-bundle`

- `white-october/pagerfanta-bundle`

- `willdurand/hateoas-bundle`

- `jms/serializer-bundle`

And for testing proposal:

- `lakion/api-test-case`

- `behat/symfony2-extension`

- `behat/behat`

- `guzzlehttp/guzzle`


###The folder structure is:

    src
      \
      Leos
        |
        |\ Application     `Contains the Use Cases of the domain system and the Data Transfer Objects`
        |
        |\ Domain          `The system business logic layer`
        |
        |\ Infrastructure  `Its the implementation of the system outside the model. I.E: Persistence, serialization, etc`
        |
         \ UI              `User Interface. This use to be inside the Infrastructure layer, but I don't want.`

###The tests

The tests follow the same structure and the *phpunit* tests are tagged with group tags: *unit* or *functional*.
The PHPUnit test don't need nginx to run.

The *aceptation tests* are inside the test UI layer and attack the application form outside the fpm container using Guzzle.
That simulate external connections and at the same time it's possible to test the connection with nginx.

###The Environment

The environment is in PHP7 and the development containers are on `etc/infrastructure/dev/docker-compose.yml`

Run the environment with: `docker-compose -f etc/infrastructure/dev/docker-compose.yml up -d`

###The deployment

The deployment script is `etc/infrastructure/deploy.sh` and require the releaseId as argument to work.
The deploy file is a shit write in bash, yes, but has all the steps that you have to follow (except git logic) to deploy following a common sense container based system.

To test the pipeline:

    $ cd etc/infrastructure/
    $ ./deploys <release>
