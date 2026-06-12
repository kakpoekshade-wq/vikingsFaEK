# Stratégie de travail en équipe — TP Vikings

## Membres du groupe
- Ekshade Kakpo
- Fanta Samassa

## Lien du repository GitHub
https://github.com/kakpoekshade-wq/vikingsFaEK.git

## Organisation du travail

Nous avons travaillé en **pair programming** tout au long du projet :
ensemble, au même endroit, au même moment. Une personne écrivait le code
pendant que l'autre relisait, corrigeait et testait en temps réel.
Cette méthode nous a permis de détecter les erreurs rapidement et de
maintenir une compréhension commune de l'ensemble du code.

## Déroulement du projet

### Étape 1 — Base de données
Nous avons commencé par concevoir et créer la structure SQL :
- Création de la table `weapon` avec les colonnes `id`, `type`, `damage`
- Modification de la table `viking` pour ajouter la colonne `weaponId`
- Ajout de la contrainte de clé étrangère `fk_viking_weapon` avec `ON DELETE SET NULL`
  pour gérer automatiquement la suppression des armes associées aux vikings (bonus)

### Étape 2 — DAO des armes
Création du fichier `api/dao/weapon.php` avec les 5 fonctions :
- `findOneWeapon` : récupérer une arme par son id
- `findAllWeapons` : récupérer toutes les armes avec filtre, limite et offset
- `createWeapon` : insérer une nouvelle arme
- `updateWeapon` : modifier une arme existante
- `deleteWeapon` : supprimer une arme

### Étape 3 — Routes des armes
Création du dossier `api/weapon/` avec les fichiers :
- `findOne.php` : GET, retourne une arme par id
- `find.php` : GET, retourne toutes les armes avec limite et offset
- `create.php` : PUT, crée une nouvelle arme
- `update.php` : PATCH, modifie une arme existante
- `delete.php` : DELETE, supprime une arme
- `service.php` : fonction `verifyWeapon` pour valider les données

### Étape 4 — Mise à jour du DAO des vikings
Modification de `api/dao/viking.php` :
- Ajout de `weaponId` dans les requêtes SELECT de `findOneViking` et `findAllVikings`
- Transformation du `weaponId` en lien HATEOAS (`/weapon/findOne.php?id=X`) ou `""`
- Mise à jour de `createViking` et `updateViking` pour accepter `weaponId` optionnel
- Création de `updateVikingWeapon` : met à jour uniquement le champ `weaponId`
- Création de `findVikingsByWeapon` : retourne les vikings d'une arme en format HATEOAS (bonus)

### Étape 5 — Mise à jour des routes des vikings
Modification et création dans `api/viking/` :
- `findOne.php` et `find.php` : retournent désormais l'arme en lien HATEOAS
- `create.php` : vérifie l'existence de l'arme avant de créer le viking
- `update.php` : vérifie l'existence de l'arme avant de mettre à jour le viking
- `updateWeapon.php` : PATCH, met à jour uniquement l'arme d'un viking, accepte `null` pour retirer l'arme
- `findByWeapon.php` : GET, retourne tous les vikings possédant une arme donnée (bonus)

### Étape 6 — Tests Postman
Tests complets de toutes les routes :
- CRUD complet des armes
- CRUD complet des vikings avec gestion du `weaponId`
- Vérification des erreurs (404, 412, 405)
- Vérification du format HATEOAS
- Test du bonus `ON DELETE SET NULL`
- Test du bonus `findByWeapon`

## Difficultés rencontrées
- La gestion du `weaponId` à `null` dans `updateWeapon.php` nécessitait
  l'utilisation de `array_key_exists` plutôt que `isset`, car `isset` retourne
  `false` si la valeur est `null`
- La correction de `getBody()` dans `server.php` pour gérer les cas où le body
  est vide en ajoutant `?? []`
- La mise en place de la méthode PATCH dans `methodIsAllowed()` de `server.php`

## Outils utilisés
- MAMP (serveur local PHP/MySQL)
- phpMyAdmin (gestion de la base de données)
- Postman (tests des routes API)
- GitHub (versioning du code) : https://github.com/kakpoekshade-wq/vikingsFaEK.git
- Visual Studio Code (éditeur de code)