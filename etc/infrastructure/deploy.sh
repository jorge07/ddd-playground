# This is more or less the the workflow to follow on CI

#!/usr/bin/env bash

[[ -z "${1// }" ]] &&  echo "Need release ID" && exit 1

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

function sayInRed {
    printf "\033[1;31m$@\033[0m\n"
}

sayInRed "Wait a minute, this a very little example about how to make a deployment with docker"

sayInRed "Create the deploy folder"
mkdir -p context-${RELEASE}/build

sayInRed "Up environment"
step docker-compose -f build/docker-compose.yml build
step docker-compose -f build/docker-compose.yml up -d
docker exec sf-build-${RELEASE} php bin/console d:d:c
step docker exec sf-build-${RELEASE} php bin/console d:s:u --force

sayInRed "Running the tests"
step docker exec sf-build-${RELEASE} phpunit
step docker exec sf-build-${RELEASE} ./vendor/bin/behat

sayInRed "Extract reporting"
step docker cp sf-build-${RELEASE}:/app/report ../../report

sayInRed "Remove test container directories"
step docker-compose -f build/docker-compose.yml down

sayInRed "Create the Building container"
step docker build -t sf-build-${RELEASE} -f build/fpm/Dockerfile ../../

sayInRed "Ship the container to export the compiled files"
step docker run -d --name building-${RELEASE} sf-build-${RELEASE}
step docker cp building-${RELEASE}:/app context-${RELEASE}/build/

sayInRed "Remove environment"
step docker rm -f building-${RELEASE}

sayInRed "Create the final container context"
step cp -R prod/fpm context-${RELEASE}/build/fpm
step cp -R prod/nginx context-${RELEASE}/build/nginx

sayInRed "Build the production images"
step docker-compose -f prod/docker-compose.yml build

# TODO Push images to registry

sayInRed "Clean directories"
rm -rf context-${RELEASE}

sayInRed "Done see you new image details: \n\n`docker images |grep prod` \n\nNow move it into jenkins file or other CI."
