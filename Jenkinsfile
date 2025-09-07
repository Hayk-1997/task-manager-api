pipeline {
    agent any

    environment {
        LARADOCK_PATH = "${WORKSPACE}/laradock"   // path to Laradock folder
        WORKSPACE_CONTAINER = "workspace" // name of workspace container
    }

    stages {
        stage('Build') {
            steps {
                echo 'Starting Laradock containers...'
                dir("${LARADOCK_PATH}") {
                    sh 'docker-compose up -d nginx mysql php-fpm workspace nginx'
                }
            }
        }

        stage('Migrate & Seed DB') {
            steps {
                echo 'Running migrations & seeds in workspace container...'
                dir("${LARADOCK_PATH}") {
                    sh "docker exec -i ${WORKSPACE_CONTAINER} php artisan migrate --force"
                    sh "docker exec -i ${WORKSPACE_CONTAINER} php artisan db:seed --force"
                }
            }
        }

        stage('PHP Version') {
            steps {
                echo 'Checking PHP version...'
                dir("${LARADOCK_PATH}") {
                    sh "docker exec -i ${WORKSPACE_CONTAINER} php -v"
                }
            }
        }
    }

    post {
        always {
            echo 'Stopping containers...'
            dir("${LARADOCK_PATH}") {
                sh 'docker-compose down'
            }
        }
    }
}
