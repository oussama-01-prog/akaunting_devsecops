pipeline {
    agent any
    options {
        timestamps()
    }

    // SECTION CRITIQUE : Définit l'environnement pour utiliser votre PHP 8.1
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
                    # Liste des extensions vitales pour Laravel et leur nom dans 'php -m'
                    declare -A REQUIRED_EXTS
                    REQUIRED_EXTS=(
                        ["mbstring"]="mbstring"
                        ["curl"]="curl"
                        ["openssl"]="openssl"
                        ["PDO (SQLite)"]="pdo_sqlite"  # pdo_sqlite implique que PDO est chargé
                        ["JSON"]="json"
                        ["bcmath"]="bcmath"
                        ["tokenizer"]="tokenizer"
                        ["ctype"]="ctype"
                        ["XML"]="xml"
                    )
                    
                    for DISPLAY_NAME in "${!REQUIRED_EXTS[@]}"; do
                        EXT_NAME="${REQUIRED_EXTS[$DISPLAY_NAME]}"
                        if php -m | grep -q "^${EXT_NAME}\$"; then
                            echo "✅ ${DISPLAY_NAME}"
                        else
                            echo "❌ ${DISPLAY_NAME} - EXTENSION MANQUANTE"
                        fi
                    done
                    echo "=========================================="
                '''
            }
        }

        stage('Checkout du Code') {
            steps {
                // Syntaxe de checkout explicite qui fonctionne dans tout type de job Jenkins
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
                    # Installation locale de Composer pour ce projet uniquement
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
                    # Copie du fichier .env si nécessaire
                    if [ ! -f .env ]; then
                        if [ -f .env.example ]; then
                            cp .env.example .env
                            echo ".env créé à partir de .env.example"
                        else
                            echo "⚠️  .env.example non trouvé, création d'un .env vide"
                            echo "# Configuration Laravel" > .env
                        fi
                    fi
                    
                    # Création de la base de données SQLite
                    mkdir -p database
                    touch database/database.sqlite
                    echo "Base de données SQLite créée : database/database.sqlite"
                    
                    # Forcer la configuration SQLite dans .env
                    sed -i.bak '/^DB_CONNECTION=/d' .env
                    sed -i.bak '/^DB_DATABASE=/d' .env
                    echo "DB_CONNECTION=sqlite" >> .env
                    echo "DB_DATABASE=database/database.sqlite" >> .env
                    
                    # Permissions des dossiers Laravel
                    mkdir -p storage/framework/{cache,sessions,views}
                    chmod -R 775 storage bootstrap/cache 2>/dev/null || true
                    
                    # Génération de la clé d'application
                    php artisan key:generate --force
                    echo "✅ Configuration Laravel terminée"
                '''
            }
        }

        stage('Installer les Dépendances') {
            steps {
                sh '''
                    echo "========== INSTALLATION DES DÉPENDANCES =========="
                    # Installation avec optimisation, en ignorant temporairement les prérequis système
                    ./composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs
                    
                    # Regénération de l'autoloader après installation
                    ./composer dump-autoload --optimize
                    
                    echo "✅ Dépendances installées avec succès"
                '''
            }
        }

        stage('Pré-cache Laravel') {
            steps {
                sh '''
                    echo "========== PRÉ-CACHE DE L'APPLICATION =========="
                    # Nettoyage et mise en cache de la configuration
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
                    # Exécution des tests avec arrêt au premier échec
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
            // Archivage optionnel des logs pour débogage
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
            echo "🕒 Pipeline terminé à : $(date)"
        }
    }
}