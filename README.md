DDD Playground
==============

> For a more acurated DDD, CQRS and Event Sourcing implementation [see here](https://github.com/jorge07/symfony-4-es-cqrs-boilerplate)

**Wallet API** in Symfony following DDD (Domain Driver Design). 

### Examples in the repo

   - [x] **User authentication** based in JWT 
   - [x] **UUID as binary** to improve the performance and create a nightmare for the dba.
   - [x] Automated tasks with ant.
   - [x] **Dev and CI environments in Docker**. Boosting build speed with docker **cache layers** in pipeline. Orchestrating with **Docker Compose**.
   - [x] An example of **table inheritance and discriminator strategy** 
   - [x] How to deal with **EAV** (Entity-Attribute-Value) with **Json data type**.
   - [x] Code structured in layers as appears in DDD in php book.
   - [x] Test for api in **behat** accessing via web server (*Acceptance tests*). 
   - [x] Integration test with **Lakion api test case** and **Alice** for fixtures and how to integrate it with **behat**. 
   - [x] **Command Bus** implementation
   - [x] DomainEvents
   - [x] Events to RabbitMQ
   - [x] Events stored in ElasticSearch and Kibana for reading in `:5601`
   


### The folder structure 

    src
      \
       |\ Application     `Contains the Use Cases of the domain system and the Data Transfer Objects`
       |
       |\ Domain          `The system business logic layer`
       |
       |\ Infrastructure  `Its the implementation of the system outside the model. I.E: Persistence, serialization, etc`
       |
        \ UI              `User Interface. This use to be inside the Infrastructure layer, but I don't like it.`

### The tests

The tests follow the same structure and the *phpunit* tests are tagged with group tags: *unit* or *functional*.

The *aceptation tests* are inside the test `UI` layer and attack the application from outside using Guzzle.

### The Environment setup

The environment is in PHP7.1 and the development containers are on `etc/infrastructure/dev/docker-compose.yml`

Up environment with: `docker-compose -f etc/infrastructure/dev/docker-compose.yml up -d`

Install dependencies: `docker-compose -f etc/infrastructure/dev/docker-compose.yml exec fpm sh -lc 'COMPOSER_MEMORY_LIMIT=-1 composer install'`

Setup database, etc with : `docker-compose -f etc/infrastructure/dev/docker-compose.yml exec fpm sh -lc 'ant build'`

Start **async** listeners: `docker-compose -f etc/infrastructure/dev/docker-compose.yml exec fpm sh -lc 'bin/console rabbitmq:multiple-consumer events'`

- Rabbit Management: `:15672`
![Rabbit](https://i.imgur.com/Wx881tI.png)

- Kibana: `:5601`
![Kibana](https://i.imgur.com/AKsVA0t.png)

### CI/CD

Follow the `Jenkinsfile` or the `gitlab-ci.yml` file, it's clear enough and contains a simply workflow to:

- build the isolated environment
- `docker-compose -p` to avoid parallel jobs conflicts
- provision the environment
- run the test
- extract reports
- Build and store the artifacts (Docker images)
- Clean the environment
