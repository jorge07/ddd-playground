#!/usr/bin/env bash

export RELEASE=$1

# Stop on error
function step {
    "$@"
    local status=$?
    if [ $status -ne 0 ]; then
        echo -e "error with $1" >&2
        docker rm -f building-${RELEASE}
        rm -rf context-${RELEASE}
        exit $status
    fi
}

# This is more or less the the workflow to follow on jenkins

echo -e "Wait a minute, this a very little example about how to make a deployment with docker"

echo -e "Create the deploy folder"
mkdir -p context-${RELEASE}/build

echo -e "Up environment"
step docker-compose -f build/docker-compose.yml up -d
docker exec sf-build-${RELEASE} php bin/console d:d:c
step docker exec sf-build-${RELEASE} php bin/console d:s:u --force

echo -e "Running the tests"
step docker exec sf-build-${RELEASE} phpunit

echo -e "Extract reporting"
step docker cp sf-build-${RELEASE}:/app/report ../../report

echo -e "Remove test container directories"
step docker-compose -f build/docker-compose.yml down -v

echo -e "Create the Building container"
step docker build -t sf-build-${RELEASE} -f build/fpm/Dockerfile ../../

echo -e "Ship the container to export the compiled files"
step docker run -d --name building-${RELEASE} sf-build-${RELEASE}
step docker cp building-${RELEASE}:/app context-${RELEASE}/build/

echo -e "Remove environment"
step docker rm -f building-${RELEASE}
step docker-compose -f build/docker-compose.yml down -v

echo -e "Create the final container context"
step cp -R prod/fpm context-${RELEASE}/build/fpm
step cp -R prod/nginx context-${RELEASE}/build/nginx

echo -e "Build the production images"
step docker-compose -f prod/docker-compose.yml build

# TODO Push images to registry

echo -e "Clean directories"
rm -rf context-${RELEASE}

echo -e "Done see you new image details: \n\n `docker images |grep prod` \n\nNow move it into jenkins file or other CI."
