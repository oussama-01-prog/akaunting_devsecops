pipeline {
    agent any
    options { timestamps() }

    environment {
        APP_ENV = 'testing'
        APP_KEY = 'base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA='
        APP_DEBUG = 'false'
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
APP_ENV=production
APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=
APP_DEBUG=false

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
                    composer install --no-dev --no-scripts --no-interaction --prefer-dist --no-progress
                '''
            }
        }

        stage('Laravel build & tests') {
            steps {
                sh '''
                    php artisan key:generate --force
                    php artisan config:clear
                    php artisan config:cache
                    php artisan package:discover --ansi
                    php artisan test
                '''
            }
        }

    }

    post {
        success { echo "✅ Build + Tests succeeded" }
        failure { echo "❌ Build or Tests failed" }
    }
}
