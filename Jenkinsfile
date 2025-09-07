pipeline {
    agent any

    environment {
        LARADOCK_PATH = "${WORKSPACE}/laradock"   // path to Laradock folder
        WORKSPACE_CONTAINER = "workspace" // workspace container name
    }

    stages {
        stage('Prepare Env') {
            steps {
                echo 'Preparing environment file...'
                dir("${LARADOCK_PATH}") {
                    sh '''
                        if [ ! -f .env ]; then
                            cp .env.example .env
                            echo ".env file created from .env.example"
                        else
                            echo ".env already exists, skipping copy"
                        fi
                    '''
                }
            }
        }

        stage('Build') {
            steps {
                echo 'Starting Laradock containers...'
                dir("${LARADOCK_PATH}") {
                    sh 'docker-compose up -d nginx mysql php-fpm workspace'
                }
            }
        }

        stage('Migrate & Seed DB') {
            steps {
                echo 'Running migrations & seeds...'
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
