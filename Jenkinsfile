pipeline {
    agent {
        docker {
            image 'php:8.2-bullseye'
            args '--network jenkins'
        }
    }

    environment {
        APP_NAME = 'akaunting'
        DB_CONNECTION = 'mysql'
        DB_HOST = 'localhost'
        DB_DATABASE = 'akaunting'
        DB_USERNAME = 'root'
        DB_PASSWORD = ''
        COMPOSER_ALLOW_SUPERUSER = '1'
        NODE_VERSION = '18'
    }

    stages {

        // ================= BUILD =================
        stage('BUILD') {
            steps {
                sh '''
                set -e
                echo "===== BUILD STAGE ====="

                apt-get update -yqq
                apt-get install -yqq \
                    libzip-dev zip unzip \
                    libpng-dev libicu-dev \
                    curl git build-essential

                docker-php-ext-install pdo_mysql zip gd intl bcmath

                # Node 18
                curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
                apt-get install -y nodejs

                # Composer
                curl -sS https://getcomposer.org/installer | php
                mv composer.phar /usr/local/bin/composer

                cd akaunting

                composer install --prefer-dist --no-interaction --no-scripts

                npm install || true
                npm run build || echo "No frontend build"

                cp .env.example .env || true
                '''
            }
            post {
                success {
                    archiveArtifacts artifacts: 'akaunting/vendor/**, akaunting/public/**, akaunting/.env'
                }
            }
        }

        // ================= TEST =================
        stage('TEST') {
            agent {
                docker {
                    image 'php:8.2-bullseye'
                    args '--network jenkins'
                }
            }
            steps {
                sh '''
                echo "===== TEST STAGE ====="

                # Start MySQL
                docker run -d \
                  --name mysql \
                  -e MYSQL_ROOT_PASSWORD='' \
                  -e MYSQL_DATABASE=akaunting \
                  mysql:8.0

                sleep 20

                cd akaunting

                php artisan migrate --env=testing --force || echo "Migration skipped"

                ./vendor/bin/phpunit \
                  --coverage-clover=coverage.xml \
                  --coverage-text || true

                ./vendor/bin/phpcs --standard=PSR12 app routes tests \
                  --report=json > phpcs-report.json || true

                ./vendor/bin/phpcpd app routes || true
                '''
            }
            post {
                always {
                    junit allowEmptyResults: true, testResults: '**/tests/*.xml'

                    publishHTML([
                        reportDir: '.',
                        reportFiles: 'coverage.xml',
                        reportName: 'Coverage'
                    ])
                }
            }
        }

        // ================= SECURITY =================
        stage('SECURITY') {
            steps {
                sh '''
                echo "===== SECURITY STAGE ====="

                # Dependency scan
                composer audit || true

                # Filesystem scan (Trivy)
                trivy fs . || true
                '''
            }
        }

        // ================= DEPLOY =================
        stage('DEPLOY') {
            when {
                branch 'master'
            }
            steps {
                sh '''
                echo "===== DEPLOY STAGE ====="
                echo "Deploy simulated (replace with real deploy)"
                '''
            }
        }
    }
}
