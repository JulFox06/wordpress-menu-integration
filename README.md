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
   `composer install --no-dev`

4. **Build les assets pour le bon fonctionnement du thème**  
   `npm run build`

## Lancer l'environnement `wp-env`

Une fois les dépendances installées, démarrez l'environnement local avec la commande suivante :  
`npm run wp-env:start`

Cela créera et démarrera un environnement WordPress local basé sur Docker. Vous pourrez accéder au site via une URL locale générée (par exemple, `http://localhost:8888`).

### Accéder à l'interface d'administration

Pour accéder à l'interface d'administration de WordPress, utilisez les identifiants suivants :

- **URL :** `http://localhost:8888/wp-admin`
- **Identifiant :** `admin`
- **Mot de passe :** `password`

### Consignes d'intégration

Une fois connecté en back-office, il vous suffit de choisir le thème `Jrenard` depuis le menu Apparence.

Le méga menu s'intégre depuis une page d'options disponible en back-office. Quelques assets sont présents dans le dossier `_INTEGRATION` de ce dépôt.

- rendez-vous donc sur ce lien : http://localhost:8888/wp-admin/admin.php?page=options-header
- remplissez les différents champs, à commencer par la section "Général".
- remplissez ensuite la section "Menu". Il s'agit ici de champs répéteurs ACF :
  - en ajoutant un élément, vous aurez la possibilité de définir s'il s'agit d'un lien ou non. Si ce n'est pas un lien, c'est alors un mega-menu.
  - pour les méga-menus, une section est obligatoire (une seule ne définit qu'un deuxième niveau, plusieurs sections permet alors de faire trois niveaux de menu).
  - pour chaque section, vous pouvez ajouter autant de vignette que nécessaire (avec la possibilité de mettre une image, un titre, un lien et un extrait).
