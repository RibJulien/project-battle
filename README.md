
# Project Battle

Réalisé entre le 17/02/22 et le 23/02/22

Lien en production : [Project-Battle](https://project-battle.julien-ribeaucourt.fr)

![forthebadge](http://forthebadge.com/images/badges/built-with-love.svg) ![forthebadge](https://forthebadge.com/images/badges/built-by-developers.svg)
## Sommaire

1. Description
2. Installation
3. Fonctionnement
4. Technologies utilisées
5. Améliorations possibles
7. Licence

## Description

_Project-Battle_ est un mini projet consistant à pouvoir créer des joueurs avec des caractéristiques, puis de les faire se rencontrer lors d'un affront entre 2 équipes.
À la suite de cet affront, une équipe est désignée gagnante, et un récapitulatif de chaque tour est affiché.

## Installation

Suivez ces instructions pour installer le projet en local sur votre ordinateur.

### Pré-requis :

1. _PHP 7_
2. Un serveur local (ex : _laragon, wamp/lamp_)
3. Le logiciel de gestionnaire de dépendance : _Composer_


### Déroulement de l'installation :

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

Vous pouvez ensuite allumer votre serveur :

``php bin/console server:run``

Puis vous rendre dans votre navigateur à cette url pour accéder au projet :

``127.0.0.1:8000``

## Fonctionnement

#### 1. Joueur

Il est possible de créer un joueur depuis la page d'accueil du site et de lui assigner des caractéristiques.
La suppression d'un joueur se fait également depuis la page d'accueil, avec un bouton **Supprimer** disponible sur chaque carte de joueur.
Un joueur est une entité Symfony, lié à la base de données grâce à l'ORM Doctrine.

#### 2. Combat

Un combat peut être lancé depuis la page d'accueil du site avec le bouton **Organiser un combat**.
Le déroulement du combat :

1. Chaque joueur est assigné à une équipe aléatoirement (les équipes peuvent ne pas être équilibrés).

2. Un ordre de tour par joueur est défini en fonction de l'initiative.

3. Lorsque c'est le tour du joueur : Il choisit une cible dans l'équipe adverse en fonction de la menace des ennemis.
_ex : Un ennemi avec  4 de menaces aura 4 fois plus de chance d'être pris pour cible, qu'un ennemi avec 1 de menace._

4. L'agilité de l'attaquant va ensuite définir si son attaque va toucher sa cible. 
    Voici la formule : ``$agility*100/15/2+50`` , le taux de toucher est toujours supérieur à 50% pour éviter un combat trop long.
    
5. Si tous les joueurs d'une équipe sont morts, le combat est terminé, sinon, c'est au tour du joueur suivant.

En image :

![Image du déroulement du combat](/public/img/fight_algo.png "Déroulement du combat")

## Technologies utilisées

![HTML5](https://res.cloudinary.com/practicaldev/image/fetch/s--oicIUVtB--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_880/https://img.shields.io/badge/HTML5-E34F26%3Fstyle%3Dfor-the-badge%26logo%3Dhtml5%26logoColor%3Dwhite) ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white) ![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white) ![JS](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black) ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) ![MYSQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
## Améliorations possibles


- [ ] Possibilité de créer un joueur avec des caractéristiques générées aléatoirement.

- [ ] Mettre une limite de point de caractéristique à attribuer à chaque joueur lors de la création, pour équilibrer les combats.

- [ ]  Lorsque deux joueurs ont autant d'initiative, décider aléatoirement qui sera le premier à jouer des deux. (Actuellement celui avec l'ID le plus faible en base de données sera toujours prioritaire).

- [ ] Lors de la génération aléatoire des équipes : Le joueur 1 et le joueur 2 seront forcément dans deux équipes différentes, pour éviter qu'une équipe soit vide. Trouver un moyen pour faire deux équipes complétement aléatoire, mais qui ne peuvent pas être vide.

## Licence

Les images utilisés proviennent du site [Flaticon](https://www.flaticon.com).
