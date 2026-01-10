pipeline {
    agent any
    options {
        timestamps()
    }

    stages {

        stage('Checkout') {
            steps {
                cleanWs()
                git branch: 'master',
                    url: 'https://github.com/oussama-01-prog/akaunting_devsecops.git'
            }
        }

        stage('Check versions') {
            steps {
                sh '''
                    php -v
                    composer --version
                '''
            }
        }

        stage('Prepare environment') {
            steps {
                sh '''
                    set -e

                    if [ ! -f .env ]; then
                      cat <<EOF > .env
APP_ENV=testing
APP_KEY=
APP_DEBUG=true

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

CACHE_DRIVER=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync
EOF
                    fi

                    mkdir -p database
                    touch database/database.sqlite
                '''
            }
        }

        stage('Composer install') {
            steps {
                sh '''
                    composer install --no-interaction --prefer-dist --no-progress
                '''
            }
        }

        stage('Laravel tests') {
            steps {
                sh '''
                    php artisan key:generate --force
                    php artisan test
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Tests Akaunting OK"
        }
        failure {
            echo "❌ Tests failed"
        }
    }
}
