#!/usr/bin/env groovy


node('node') {


    gitCommit = sh(returnStdout: true, script: 'git rev-parse HEAD').trim()

    shortCommit = gitCommit.take(6)

    currentBuild.result = "SUCCESS"

    try {

       stage 'Checkout'

            checkout scm

       stage 'Build'

            sh 'sudo docker pull jorge07/alpine-php:7.1-dev-sf'
            sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml pull"
            sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml build"
            sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml up -d"
            sh "sudo docker run ${shortCommit}_fpm_1 ant build"

       stage 'Unit test'

            sh "docker exec ${shortCommit}_fpm_1 ant unit-and-functional"

       stage 'Integration test'

            sh "docker exec ${shortCommit}_fpm_1 ant acceptation"

        stage 'Clean up'

            sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml down --volumes"

    } catch (err) {

        currentBuild.result = "FAILURE"
        throw err
    }
}
