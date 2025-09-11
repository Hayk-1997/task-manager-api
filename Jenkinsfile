pipeline {
    agent any

    environment {
        LARADOCK_PATH = "${WORKSPACE}/laradock"   // path to Laradock folder
        WORKSPACE_CONTAINER = "manager-workspace-1" // workspace container name
    }

    stages {
        stage('Prepare Env') {
            steps {
                echo "Preparing environment file..."
                echo "LARADOCK_PATH: ${LARADOCK_PATH}"
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
                    sh 'docker exec manager-workspace-1 bash -c "php -v && composer --version"'
                }
            }
        }

        stage('Migrate & Seed DB') {
            steps {
                echo 'Running migrations & seeds...'
                dir("${LARADOCK_PATH}") {
                    sh "docker exec -i ${WORKSPACE_CONTAINER} php artisan migrate:rollback"
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
            echo 'Finish process...'
        }
    }
}
