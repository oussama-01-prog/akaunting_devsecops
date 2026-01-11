pipeline {
    agent any

    environment {
        APP_ENV = "development"
        DB_HOST = "localhost"
        DB_DATABASE = "akaunting_db"
        DB_USERNAME = "root"
        DB_PASSWORD = ""
        PATH = "${env.PATH};C:\\php"  // Assure-toi que php.exe est ici
    }

    stages {
        // -----------------
        stage('Build') {
            steps {
                echo '📦 Build du projet PHP et front'
                // Installer Composer si nécessaire
                bat 'php composer.phar install --no-interaction'
                // Installer Node.js + front
                bat 'npm install'
                bat 'npm run build'
            }
        }

        // -----------------
        stage('Test') {
            steps {
                echo '✅ Lancer les tests PHP Unit'
                // Copier .env et configurer Laravel
                bat 'copy .env.example .env'
                bat 'php artisan key:generate'
                bat 'php artisan config:cache'
                bat 'php artisan migrate --force'
                // Lancer les tests
                bat 'vendor\\bin\\phpunit --colors=always'
            }
        }

        // -----------------
        stage('Deployment') {
            steps {
                echo '🚀 Déployer / lancer le serveur local pour démo'
                bat 'start php artisan serve --host=0.0.0.0 --port=8000'
            }
        }

        // -----------------
        stage('Security Checks') {
            steps {
                echo '🔒 Vérification sécurité (scans de vulnérabilité)'
                // Exemple simple : utiliser PHPStan ou un outil SAST
                bat 'vendor\\bin\\phpstan analyse --level=5 app/'
                // Optionnel : vérifier composer audit
                bat 'composer audit'
            }
        }
    }

    post {
        always {
            echo '🎯 Pipeline terminée'
        }
    }
}