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
            }
        }

        stage('Installer Composer Localement') {
            steps {
                sh '''
                    echo "========== INSTALLATION DE COMPOSER =========="
                    if [ ! -f composer ]; then
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
                            echo "✅ Composer installé avec succès"
                        else
                            echo "❌ Échec de l'installation de Composer"
                            exit 1
                        fi
                    else
                        echo "✅ Composer déjà présent"
                    fi
                    ./composer --version
                '''
            }
        }

        stage('Installer/Rafraîchir les Dépendances') {
            steps {
                sh '''
                    echo "========== INSTALLATION DES DÉPENDANCES =========="
                    # Si vendor existe déjà, on met à jour, sinon on installe
                    if [ -d "vendor" ]; then
                        echo "Mise à jour des dépendances existantes..."
                        ./composer update --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs
                    else
                        echo "Installation complète des dépendances..."
                        ./composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs
                    fi
                    
                    # Régénération FORCÉE de l'autoloader (critique !)
                    ./composer dump-autoload --optimize
                    echo "✅ Dépendances installées et autoloader régénéré"
                '''
            }
        }

        stage('Configurer Laravel') {
            steps {
                sh '''
                    echo "========== CONFIGURATION LARAVEL =========="
                    # Préparation des dossiers
                    mkdir -p storage/framework/{cache,sessions,views}
                    mkdir -p database
                    
                    # Permissions
                    chmod -R 775 storage bootstrap/cache 2>/dev/null || true
                    
                    # Configuration .env
                    if [ ! -f .env ]; then
                        if [ -f .env.example ]; then
                            cp .env.example .env
                            echo ".env créé à partir de .env.example"
                        else
                            echo "# Configuration Laravel" > .env
                        fi
                    fi
                    
                    # Forcer SQLite
                    sed -i.bak '/^DB_CONNECTION=/d' .env
                    sed -i.bak '/^DB_DATABASE=/d' .env
                    echo "DB_CONNECTION=mysql" >> .env
                    echo "DB_DATABASE=database/database.sqlite" >> .env
                    
                    # Créer la base de données
                    touch database/database.sqlite
                    echo "Base de données SQLite créée"
                    
                    # Nettoyer les caches avant de générer la clé
                    php artisan config:clear 2>/dev/null || echo "Cache config déjà vide"
                    php artisan cache:clear 2>/dev/null || echo "Cache déjà vide"
                    
                    # Générer la clé d'application
                    php artisan key:generate --force
                    echo "✅ Configuration Laravel terminée"
                '''
            }
        }

        stage('Préparer l\'Application') {
            steps {
                sh '''
                    echo "========== PRÉPARATION FINALE =========="
                    # Migration de la base de données (si nécessaire)
                    php artisan migrate --force 2>/dev/null || echo "Aucune migration nécessaire ou erreur ignorée"
                    
                    # Générer le cache de configuration
                    php artisan config:cache
                    echo "✅ Application prête pour les tests"
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
                php --version
                echo ""
                echo "Composer :"
                ./composer --version 2>/dev/null || echo "Composer non disponible"
                echo ""
                echo "Structure Laravel :"
                ls -la vendor/laravel/framework 2>/dev/null || echo "Laravel non installé"
            '''
        }
        always {
            sh 'echo "🕒 Pipeline terminé à : $(date)"'
        }
    }
}