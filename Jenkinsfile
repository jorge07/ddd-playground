pipeline {

    agent { node { label any } }

    environment {
        APP_NAME = 'DDD'
    }

    stages {

        stage("Checkout") {
            steps {

                checkout scm
                shortCommit = sh(returnStdout: true, script: 'git rev-parse HEAD').trim().take(6)
            }
        }

        stage("Environment") {
            steps {

                sh 'sudo docker pull jorge07/alpine-php:7.1-dev-sf'
                sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml pull"
                sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml build"
                sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml up -d"
            }
        }

        stage("Build") {
            steps {

                sh "sudo docker exec ${shortCommit}_fpm_1 ant build"
            }
        }

        stage("Unit test") {
            steps {

               sh "sudo docker exec ${shortCommit}_fpm_1 ant unit-and-functional"
            }
        }

        stage("Integration test") {
            steps {

               sh "sudo docker exec ${shortCommit}_fpm_1 ant acceptation"
            }
        }
    }

    post {
        success {

            slackSend (color: '#43A047', message: "${env.APP_NAME} -> All green. See: (${env.BUILD_URL})")
        }

        failure {

            slackSend (color: '#CF0000', message: "${env.APP_NAME} -> Ops! Something was wrong... See: (${env.BUILD_URL})")
        }
        always {

            sh "sudo docker-compose -p ${shortCommit} -f etc/infrastructure/build/docker-compose.yml down --volumes"
        }
    }
}
