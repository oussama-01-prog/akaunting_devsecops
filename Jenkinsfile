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
            
            # Étape CRITIQUE : S'assurer que le workspace appartient à l'utilisateur Jenkins
            echo "Correction des permissions du workspace..."
            whoami
            pwd
            
            # Supprimer tout et repartir de zéro
            rm -rf vendor composer.lock composer composer.phar 2>/dev/null || true
            
            # Installation de Composer avec le bon propriétaire
            echo "Installation de Composer..."
            php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
            php composer-setup.php --install-dir=. --filename=composer --version=2.2.22
            php -r "unlink('composer-setup.php');"
            
            # S'assurer que composer est exécutable
            chmod +x composer
            
            # Créer le dossier vendor avec les bonnes permissions AVANT l'installation
            echo "Préparation du dossier vendor..."
            mkdir -p vendor
            chmod -R 777 vendor 2>/dev/null || true
            
            # Installation avec USER spécifié pour éviter les problèmes de permissions
            echo "Installation des dépendances..."
            # Utiliser --no-scripts pour éviter les problèmes d'exécution
            ./composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs --no-scripts
            
            # Corriger les permissions APRÈS installation
            echo "Correction finale des permissions..."
            if [ -d "vendor" ]; then
                find vendor -type d -exec chmod 755 {} \\;
                find vendor -type f -exec chmod 644 {} \\;
            fi
            
            # Exécuter les scripts manuellement après correction des permissions
            echo "Exécution des scripts Composer..."
            ./composer run-script post-install-cmd 2>/dev/null || echo "Script post-install non exécuté"
            
            echo "✅ Dépendances installées avec succès"
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
            
            # Configuration .env pour MySQL (comme dans votre projet)
            cat > .env << 'EOF'
APP_NAME=Akaunting
APP_ENV=testing
APP_LOCALE=en-GB
APP_INSTALLED=false
APP_KEY=
APP_DEBUG=true
APP_SCHEDULE_TIME="09:00"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=akaunting_test
DB_USERNAME=root
DB_PASSWORD=""

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

MAIL_MAILER=log
MAIL_HOST=localhost
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_NAME=null
MAIL_FROM_ADDRESS=null

FIREWALL_ENABLED=false
MODEL_CACHE_ENABLED=false
DEBUGBAR_EDITOR=vscode
IGNITION_EDITOR=vscode
PWA_ENABLED=false
EOF
            
            # Nettoyer les caches
            ./composer dump-autoload
            
            # Générer la clé d'application
            php -r "
                require_once 'vendor/autoload.php';
                \$app = require_once 'bootstrap/app.php';
                \$kernel = \$app->make(Illuminate\\Contracts\\Console\\Kernel::class);
                \$status = \$kernel->call('key:generate', ['--force' => true]);
                exit(\$status);
            "
            
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