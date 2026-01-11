pipeline {
    agent any
    options {
        timestamps()
    }

    environment {
        PATH = "/usr/local/php8.1/bin:/usr/local/bin:${env.PATH}"
    }

    stages {
        stage('Vérifier PHP') {
            steps {
                sh '''
                    echo "========== ENVIRONNEMENT PHP =========="
                    echo "Chemin de PHP : $(which php)"
                    php --version
                    echo ""
                    echo "========== VÉRIFICATION DES EXTENSIONS =========="
                    # Vérification simplifiée sans tableaux associatifs (compatible avec dash)
                    EXTENSIONS="mbstring curl openssl pdo_sqlite json bcmath tokenizer ctype xml"
                    for EXT in $EXTENSIONS; do
                        if php -m | grep -q "^$EXT\$"; then
                            case $EXT in
                                mbstring) echo "✅ mbstring" ;;
                                curl) echo "✅ curl" ;;
                                openssl) echo "✅ openssl" ;;
                                pdo_sqlite) echo "✅ PDO (SQLite)" ;;
                                json) echo "✅ JSON" ;;
                                bcmath) echo "✅ bcmath" ;;
                                tokenizer) echo "✅ tokenizer" ;;
                                ctype) echo "✅ ctype" ;;
                                xml) echo "✅ XML" ;;
                                *) echo "✅ $EXT" ;;
                            esac
                        else
                            case $EXT in
                                pdo_sqlite) echo "❌ PDO (SQLite) - EXTENSION MANQUANTE" ;;
                                *) echo "❌ $EXT - EXTENSION MANQUANTE" ;;
                            esac
                        fi
                    done
                    echo "=========================================="
                '''
            }
        }

        stage('Checkout du Code') {
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
                        noTags: true
                    ]]
                ])
                sh '''
                    echo "Dépôt cloné avec succès"
                    ls -la
                '''
            }
        }

        stage('Installer Composer Localement') {
            steps {
                sh '''
                    echo "========== INSTALLATION DE COMPOSER =========="
                    EXPECTED_CHECKSUM="$(curl -s https://composer.github.io/installer.sig)"
                    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"
                    
                    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then
                        echo "❌ ERREUR : Checksum de Composer invalide !"
                        rm composer-setup.php
                        exit 1
                    fi
                    
                    php composer-setup.php --install-dir=. --filename=composer
                    RESULT=$?
                    rm composer-setup.php
                    
                    if [ $RESULT -eq 0 ]; then
                        chmod +x composer
                        ./composer --version
                        echo "✅ Composer installé avec succès"
                    else
                        echo "❌ Échec de l'installation de Composer"
                        exit 1
                    fi
                '''
            }
        }

        stage('Configurer Laravel') {
            steps {
                sh '''
                    echo "========== CONFIGURATION LARAVEL =========="
                    if [ ! -f .env ]; then
                        if [ -f .env.example ]; then
                            cp .env.example .env
                            echo ".env créé à partir de .env.example"
                        else
                            echo "⚠️  .env.example non trouvé, création d'un .env vide"
                            echo "# Configuration Laravel" > .env
                        fi
                    fi
                    
                    mkdir -p database
                    touch database/database.sqlite
                    echo "Base de données SQLite créée : database/database.sqlite"
                    
                    sed -i.bak '/^DB_CONNECTION=/d' .env
                    sed -i.bak '/^DB_DATABASE=/d' .env
                    echo "DB_CONNECTION=sqlite" >> .env
                    echo "DB_DATABASE=database/database.sqlite" >> .env
                    
                    mkdir -p storage/framework/{cache,sessions,views}
                    chmod -R 775 storage bootstrap/cache 2>/dev/null || true
                    
                    php artisan key:generate --force
                    echo "✅ Configuration Laravel terminée"
                '''
            }
        }

        stage('Installer les Dépendances') {
            steps {
                sh '''
                    echo "========== INSTALLATION DES DÉPENDANCES =========="
                    ./composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs
                    ./composer dump-autoload --optimize
                    echo "✅ Dépendances installées avec succès"
                '''
            }
        }

        stage('Pré-cache Laravel') {
            steps {
                sh '''
                    echo "========== PRÉ-CACHE DE L'APPLICATION =========="
                    php artisan config:clear
                    php artisan config:cache
                    echo "✅ Cache de configuration généré"
                '''
            }
        }

        stage('Exécuter les Tests') {
            steps {
                sh '''
                    echo "========== EXÉCUTION DES TESTS LARAVEL =========="
                    php artisan test --stop-on-failure
                    
                    if [ $? -eq 0 ]; then
                        echo "✅ Tous les tests ont réussi"
                    else
                        echo "❌ Certains tests ont échoué"
                        exit 1
                    fi
                '''
            }
        }
    }

    post {
        success {
            echo "🎉 PIPELINE RÉUSSI ! L'environnement PHP 8.1 personnalisé fonctionne parfaitement."
            archiveArtifacts artifacts: 'storage/logs/*.log', allowEmptyArchive: true
        }
        failure {
            echo "💥 PIPELINE EN ÉCHEC"
            sh '''
                echo "========== DIAGNOSTIC FINAL =========="
                echo "Version PHP :"
                php --version 2>/dev/null || echo "PHP non disponible"
                echo ""
                echo "Composer :"
                ./composer --version 2>/dev/null || composer --version 2>/dev/null || echo "Composer non disponible"
                echo ""
                echo "Fichiers présents :"
                ls -la
            '''
        }
        always {
            sh 'echo "🕒 Pipeline terminé à : $(date)"'
        }
    }
}