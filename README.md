# Thème WordPress

Ce projet utilise [`wp-env`](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) pour configurer un environnement local de développement WordPress.

## Prérequis

Avant de commencer, assurez-vous d'avoir les outils suivants installés sur votre machine :

- [Node.js](https://nodejs.org/) (gestion des versions avec [NVM](https://github.com/nvm-sh/nvm) est recommandé)
- [Composer](https://getcomposer.org/) pour gérer les dépendances PHP
- [npm](https://www.npmjs.com/) ou [yarn](https://yarnpkg.com/) pour gérer les dépendances JavaScript

## Installation

1. **Configurer la version de Node.js**  
   À la racine du thème, utilisez NVM pour sélectionner la version correcte de Node.js :  
   `nvm use`

2. **Installer les dépendances JavaScript**  
   Une fois la version Node.js définie, installez les dépendances JavaScript :  
   `npm install`

3. **Installer les dépendances PHP / Plugins de base**  
   Installez les dépendances et plugins nécessaires pour le thème via Composer :  
   `composer install`

   L'installation d'ACF Pro est effectué pour verifier le bon fonctionnement de nos blocs ACF.

## Lancer l'environnement `wp-env`

Une fois les dépendances installées, démarrez l'environnement local avec la commande suivante :  
`npm run wp-env:start`

Cela créera et démarrera un environnement WordPress local basé sur Docker. Vous pourrez accéder au site via une URL locale générée (par exemple, `http://localhost:8888`).

### Accéder à l'interface d'administration

Pour accéder à l'interface d'administration de WordPress, utilisez les identifiants suivants :

- **URL :** `http://localhost:8888/wp-admin`
- **Identifiant :** `admin`
- **Mot de passe :** `password`

## Autres commandes utiles

- **Arrêter l'environnement :**  
  `npm run wp-env:stop`

- **Mettre à jour l'environnement :**  
  `npm run wp-env:update`

- **Corriger les erreurs PHPCS :**  
  `composer run-script phpcs:fix`
