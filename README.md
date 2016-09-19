DDD Playground
===

### Examples in the repo

   - **User authentication** split into domain and infrastructure and using Json web token 
   - Usage of **UUID as binary** to improve the performance and create a nightmare for the dba.
   - Example of **table inheritance and discriminator strategy** 
   - How to deal with **Json data type** and how to use same column for different doctrine data types. 
   - Code structured in layers as appears in DDD in php book (buenosvinos) 
   - An example of how to test the api with **behat** and guzzle and accessing to the api via web server, nginx in this case. 
   - Example of how to use phpmatcher with Lakion api test case and Alice for fixtures and how to integrate it with behat. 

### Tools

This repo its a RESTful API built following *more or less* DDD and using few useful packages like:


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


###The folder structure 

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

Follow the gitlab-ci.yml file!
