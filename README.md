# QuaiAntique


Les documents annexes sont disponibles dans le dossier ANNEXES :

    Charte graphique
    Manuel d'utilisation
    Documentation technique

Récupération du projet

Utiliser GIT Clone pour récupérer le dépôt

git clone https://github.com/Faiz334/QuaiAntique.git

Installation

# Déplacement dans le dossier
cd Quai_antique
# Installation des dépendances
composer install
# Création de la base de données
php bin/console doctrine:database:create
# Création des tables (migrations)
php bin/console doctrine:migrations:migrate
# Insertions des jeux de données (fixtures)
php bin/console doctrine:fixtures:load --no-interaction

Utilisation

symfony server:start

    Si vous utilisez Composer, il faut installer le Web Server Bundle :

composer require symfony/web-server-bundle --dev
php bin/console server:start

compte : admin = admin@admin.fr mdp=admin33
