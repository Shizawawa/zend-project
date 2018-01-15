# Mini-projet

## Description

Auteur : Elodie FLORES 4IW Groupe 1

Mini Projet : Sur une base de Zend Framework 3 (ZendSkeletonApplication) et Doctrine (comme vu en cours), vous devez gérer une liste de meetups.
Un meetup possède un titre, une description, une date de début, une date de fin.
              
## Composition

Module : Person et Rally

Rally comprend la gestion des meetups (ajouter, éditer, supprimer, la liste et le détail)

Person comprend un début de gestion des personnes et des organisations

## Déroulement du projet

Docker à été utilisé lors de l'initilaisation du projet, des différents modules et entités. Après de nombreuses erreurs, j'ai choisi d'utiliser mamp avec phpMyadmin en local et non avec docker.

Il n'y a pas de vérification pour savoir si la date de fin est bien égale ou après celle de début.

L'entité Meetup est déjà ratachée aux entités Person et Organisation. Seul leur ajout aux différents formulaire est manquant.

## Installation avec Composer

$ composer clone https://github.com/Shizawawa/zend-project.git
$ composer install

Une fois installé : 
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public/ public/index.php

OR use the composer alias:
$ composer run --timeout 0 serve

L'aaplication sera alors joignable à l'adresse 0.0.0.0:8080 dans votre navigateur

## Development mode

The skeleton ships with [zf-development-mode](https://github.com/zfcampus/zf-development-mode)
by default, and provides three aliases for consuming the script it ships with:

```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```

You may provide development-only modules and bootstrap-level configuration in
`config/development.config.php.dist`, and development-only application
configuration in `config/autoload/development.local.php.dist`. Enabling
development mode will copy these files to versions removing the `.dist` suffix,
while disabling development mode will remove those copies.

Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.


## Using docker-compose

This skeleton provides a `docker-compose.yml` for use with
[docker-compose](https://docs.docker.com/compose/); it
uses the `Dockerfile` provided as its base. Build and start the image using:

```bash
$ docker-compose up -d --build
```

At this point, you can visit http://localhost:8080 to see the site running.

You can also run composer from the image. The container environment is named
"zf", so you will pass that value to `docker-compose run`:

```bash
$ docker-compose run zf composer install
```
