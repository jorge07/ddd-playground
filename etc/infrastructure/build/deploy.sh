#!/usr/bin/env bash

# Stop on error
function step {
    "$@"
    local status=$?
    if [ $status -ne 0 ]; then
        echo -e "error with $1" >&2
        docker rm -f building
        rm -rf tmp
        exit $status
    fi
}

# This is more or less the the workflow to follow on jenkins

echo -e "Wait a minute, this a very little example about how to make a deployment with docker"

echo -e "Create the deploy folder"
mkdir -p tmp/build

echo -e "Create the Test container"
step docker build -t sf-build-test -f fpm/Dockerfile.test ../../../

echo -e "Ship the container to export the compiled files"
step docker run -d --name building-test sf-build-test

echo -e "Extract reporting"
step docker cp building-test:/app/report ../../../report

echo -e "Remove test container directories"
step docker rm -f building-test

echo -e "Create the Building container"
step docker build -t sf-build -f fpm/Dockerfile ../../../

echo -e "Ship the container to export the compiled files"
step docker run -d --name building sf-build

step docker cp building:/app tmp/build/

echo -e "Create the the context"
step cp ../prod/fpm/Dockerfile tmp/build/Dockerfile

echo -e "Build the production image"
step docker build -t sf-prod -f tmp/build/Dockerfile tmp/build/

# TODO Push images to registry

echo -e "Clean directories"
step docker rm -f building
rm -rf tmp

echo -e "Done see you new image details: \n\n `docker images |grep sf-prod` \n\nNow move it into jenkins file or other CI."
