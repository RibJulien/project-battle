
# Project Battle

## Sommaire

1. Description
2. Installation
3. Fonctionnement
4. Technologies utilisées
5.  Auteur
6. License

## Description

## Installation

Suivez ces instructions pour installer le projet en local sur votre ordinateur.

### Pré-requis :
1. _PHP 7_
2. Un serveur local (ex : _laragon, wamp/lamp_)
3. Le logiciel de gestionnaire de dépendance : _Composer_

Dans un premier temps, veuillez récupérer le projet github, grâce à la commande :
``git clone https://github.com/RibJulien/project-battle ``

Modifier ensuite le dossier de configuration _.env_ en indiquant vos identifiants pour votre base de données local :
``DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7&charset=utf8mb4"``

Pour installer toutes les dépendances du projet :
``composer update``

Créer la base de données du projet :
``php bin/console doctrine:database:create``

Passer les migrations du projet sur votre base de données :
``php bin/console doctrine:migrations:migrate``

Vous pouvez ensuite lancé le serveur :
``php bin/console server:run``

Puis vous rendre dans votre navigateur à cette url pour accéder au projet :
[127.0.0.1:8000](127.0.0.1:8000)

**Le reste de la documentation est en cours de rédaction**


