# Gestion des Rôles dans une Application Laravel

Cette section vous guide étape par étape pour implémenter la gestion des rôles dans votre application Laravel. Suivez les instructions ci-dessous pour ajouter la gestion des rôles, créer les middleware nécessaires, et configurer les routes afin de restreindre l'accès en fonction des rôles des utilisateurs.

## Table des Matières
1. [Prérequis](#prérequis)
2. [Étape 1 : Créer les Modèles et Migrations](#étape-1-créer-les-modèles-et-migrations)
3. [Étape 2 : Exécuter les Migrations et Seeders](#étape-2-exécuter-les-migrations-et-seeders)
4. [Étape 3 : Mettre à Jour les Modèles](#étape-3-mettre-à-jour-les-modèles)
5. [Étape 4 : Créer le Middleware `RoleMiddleware`](#étape-4-créer-le-middleware-rolemiddleware)
6. [Étape 5 : Enregistrer le Middleware dans le Kernel](#étape-5-enregistrer-le-middleware-dans-le-kernel)
7. [Étape 6 : Mettre à Jour le Contrôleur d'Inscription](#étape-6-mettre-à-jour-le-contrôleur-dinscription)
8. [Étape 7 : Modifier la Vue d'Inscription](#étape-7-modifier-la-vue-dinscription)
9. [Étape 8 : Configurer les Routes avec le Middleware de Rôle](#étape-8-configurer-les-routes-avec-le-middleware-de-rôle)


---

## Prérequis

- **Application Laravel Installée** : Assurez-vous d'avoir une application Laravel fonctionnelle.
- **Laravel UI avec Bootstrap** : Laravel UI doit être installé et configuré avec Bootstrap pour gérer l'authentification.
- **Connaissances de Base** : Familiarité avec les concepts de Laravel tels que les routes, middleware, modèles et migrations.

## Étape 1 : Créer les Modèles et Migrations

1. **Créer le Modèle `Role` avec Migration**  
   Générez le modèle `Role` ainsi que sa migration associée pour stocker les rôles des utilisateurs.
   
2. **Créer le Modèle `Actor` avec Migration**  
   Générez le modèle `Actor` et sa migration pour gérer les acteurs liés aux films.
   
3. **Créer la Table Pivot `role_user`**  
   Générez la migration pour la table pivot `role_user` qui établit une relation many-to-many entre les utilisateurs et les rôles.

## Étape 2 : Exécuter les Migrations et Seeders

1. **Configurer les Migrations**  
   Ouvrez les fichiers de migration générés dans le dossier `database/migrations/` et ajoutez les champs nécessaires pour chaque table (`roles`, `actors`, `role_user`).
   
2. **Créer le Seeder pour les Rôles**  
   Générez un seeder `RoleSeeder` pour initialiser les rôles dans la base de données.
   
3. **Ajouter le Seeder dans `DatabaseSeeder`**  
   Modifiez le fichier `database/seeders/DatabaseSeeder.php` pour appeler le seeder `RoleSeeder`.
   
4. **Exécuter les Migrations et Seeders**  
   Utilisez la commande Artisan pour exécuter les migrations et seeders, créant ainsi les tables et insérant les rôles.

## Étape 3 : Mettre à Jour les Modèles

1. **Mettre à Jour le Modèle `User`**  
   Ajoutez la relation many-to-many avec le modèle `Role` et implémentez la méthode `hasRole` pour vérifier les rôles de l'utilisateur.
   
2. **Mettre à Jour le Modèle `Role`**  
   Ajoutez la relation many-to-many avec le modèle `User` pour permettre l'association des rôles aux utilisateurs.
   
3. **Vérifier les Relations dans les Modèles `Film`, `Category`, et `Actor`**  
   Assurez-vous que les relations entre les modèles sont correctement définies pour une gestion efficace des données.

## Étape 4 : Créer le Middleware `RoleMiddleware`

1. **Générer le Middleware**  
   Utilisez la commande Artisan pour créer le middleware `RoleMiddleware`.
   
2. **Implémenter la Logique du Middleware**  
   Modifiez le fichier `app/Http/Middleware/RoleMiddleware.php` pour vérifier les rôles des utilisateurs avant de permettre l'accès aux routes protégées.

## Étape 5 : Enregistrer le Middleware dans le Kernel

1. **Ouvrir le Fichier Kernel**  
   Naviguez vers `app/Http/Kernel.php`.
   
2. **Ajouter le Middleware au Tableau `$routeMiddleware`**  
   Insérez `'role' => \App\Http\Middleware\RoleMiddleware::class,` dans le tableau `$routeMiddleware` pour enregistrer le middleware avec l'alias `role`.

## Étape 6 : Mettre à Jour le Contrôleur d'Inscription

1. **Ouvrir le Contrôleur `RegisterController`**  
   Modifiez le fichier `app/Http/Controllers/Auth/RegisterController.php`.
   
2. **Ajouter la Gestion des Rôles**  
   Mettez à jour les méthodes `validator` et `create` pour inclure la sélection et l'attribution des rôles lors de l'inscription des utilisateurs.

## Étape 7 : Modifier la Vue d'Inscription

1. **Ouvrir la Vue d'Inscription**  
   Modifiez le fichier `resources/views/auth/register.blade.php`.
   
2. **Ajouter un Champ Sélecteur de Rôle**  
   Insérez un élément `<select>` permettant aux utilisateurs de choisir leur rôle lors de l'inscription.

## Étape 8 : Configurer les Routes avec le Middleware de Rôle

1. **Ouvrir le Fichier des Routes Web**  
   Modifiez le fichier `routes/web.php`.
   
2. **Appliquer le Middleware `role` aux Routes**  
   Définissez des groupes de routes protégées par les middleware `auth` et `role` pour restreindre l'accès en fonction des rôles.
   
   - **Routes réservées aux administrateurs** : Accès complet, y compris la création, la mise à jour et la suppression de films.
   - **Routes réservées aux gestionnaires** : Accès limité, par exemple, création et lecture de films sans modification ou suppression.
   - **Routes réservées aux spectateurs** : Accès uniquement en lecture, sans possibilité de créer, modifier ou supprimer des films.

