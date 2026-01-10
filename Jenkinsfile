pipeline {
    agent any
    options {
        timestamps()
    }

    stages {

        stage('Git fix') {
            steps {
                sh 'git config --global http.version HTTP/1.1'
                sh 'git config --global http.postBuffer 524288000'
            }
        }

        stage('Checkout') {
            steps {
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/master']],
                    userRemoteConfigs: [[
                        url: 'https://github.com/oussama-01-prog/akaunting_devsecops.git'
                    ]],
                    extensions: [[
                        $class: 'CloneOption',
                        shallow: true,
                        depth: 1,
                        noTags: true,
                        timeout: 30
                    ]]
                ])
            }
        }

        stage('Prepare environment') {
            steps {
                sh '''
                    # Clean cache
                    rm -f bootstrap/cache/*.php

                    # Copy .env if not exists
                    if [ ! -f .env ]; then
                        cp .env.example .env
                    fi

                    mkdir -p database
                    touch database/database.sqlite
                '''
            }
        }

        stage('Composer install') {
            steps {
                sh '''
                    # Install only prod packages, skip scripts to avoid dump-server errors
                    composer install --no-dev --no-scripts --no-interaction --prefer-dist
                '''
            }
        }

        stage('Artisan commands') {
            steps {
                sh '''
                    php artisan config:clear
                    php artisan config:cache
                    php artisan key:generate --force
                '''
            }
        }

        stage('Laravel tests') {
            steps {
                sh 'php artisan test'
            }
        }
    }

    post {
        success {
            echo "✅ Tests and build completed successfully"
        }
        failure {
            echo "❌ Pipeline failed"
        }
    }
}
