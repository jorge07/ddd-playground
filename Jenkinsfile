pipeline {

    agent any

    environment {
        APP_NAME = 'DDD'
    }

    stages {

        stage("Checkout") {
            steps {

                checkout scm
            }
        }

        stage("Environment") {
            steps {

                sh 'docker pull jorge07/alpine-php:7.1-dev-sf'
                sh "docker-compose -f etc/infrastructure/build/docker-compose.yml pull"
                sh "docker-compose -f etc/infrastructure/build/docker-compose.yml build"
                sh "docker-compose -f etc/infrastructure/build/docker-compose.yml up -d"
            }
        }

        stage("Build") {
            steps {

                sh "docker exec build_fpm_1 ant build"
            }
        }

        stage("Tests") {
            steps {

                parallel(
                    "Acceptation": {

                       sh "docker exec build_fpm_1 curl nginx"
                       sh "docker exec build_fpm_1 ant acceptation"
                    },
                    "Unit and functional": {

                       sh "docker exec build_fpm_1 ant unit-and-functional"
                    }
                )
            }
        }
    }

    post {
        success {

            echo 'ok'
            // slackSend (color: '#43A047', message: "${env.APP_NAME} -> All green. See: (${env.BUILD_URL})")
        }

        failure {

            echo 'ko'
            // slackSend (color: '#CF0000', message: "${env.APP_NAME} -> Ops! Something was wrong... See: (${env.BUILD_URL})")
        }
        always {

            sh "docker-compose -f etc/infrastructure/build/docker-compose.yml down --volumes"
        }
    }
}
