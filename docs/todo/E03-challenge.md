# :card_file_box: Concevoir la BDD de MealOclock :card_file_box:

## Objectif

On s'entraîne à la conception de schemas de données, en créant la base de données du site Meal O'Clock, avec méthode ^^

Le but : obtenir le schéma des tables (avec la liste détaillée des champs), et créer la base de données du projet dans PHPMyAdmin !


## Instructions

- 2 étapes :
  - création du MCD
  - création du schéma des tables

<details><summary>Spoiler entités</summary>

- Community
- Event
- User
- Role

Maintenant, à toi de trouver les relations entre ces entités :wink:

</details>

### Création du MCD

#### Dictionnaire de données

- Parcourir le cahier des charges et les maquettes
- Faire la liste des données à stocker
- Essayer de suivre la méthode décrite :
  - d'abord, lister les données en vrac dans le dictionnaire de données
  - puis identifier les entités principales, et y rattacher les données les plus évidentes
  - tenter de placer des associations entre les entités, celles qui paraissent justes, et y rattacher les informations qui n'ont pas été "placées" dans une entité

#### Schéma Entité/Association

- Faire le schema Entité/Association (ou une version, le formalisme n'est pas encore votre priorité)
- Et surtout, essayer de se poser les bonnes questions pour construire le MLD
  - c'est à dire la liste des tables et des champs

Peu importe le format, on veut les informations suivantes :
- les entités
- les relations
- les cardinalités

<details><summary>Aide cardinalités</summary>

Pour chaque relation entre 2 entités, on doit définir une cardinalités de chaque "côté" de la relation.

Pour cela, on doit se poser la même question, dans un sens, puis dans l'autre :

- pour 1 entité#1, combien d'entité#2 ? => entre "tant" et "tant" => cardinalité côté entité#1
- (autre sens) pour 1 entité#2, combien d'entité#1 ? => entre "tant" et "tant" => cardinalité côté entité#2

</details>

#### Outils pour faire le MCD

- Google Drawings
- MOCODO
- draw.io

### Schéma de la BDD : liste précise des tables et champs

Le shéma entité/association a bien décortiqué les différentes données à stocker.  
On va pouvoir maintenant schématiser concrètement les tables et les champs de la base de données :ok_hand:

Pour cela, on va faire comme en cours :
- créer un nouveau `diagram` dans MySQLWorkBench
- créer les tables (entités)
- ajouter les champs dans les tables
- définir les relations entre les tables (entités)

A la fin, on peut sauvegarder le fichier .mwb (MySQLWorkBench, File > Save) dans son repo.

### BONUS

- exporter le PNG dans son repo
- créer la base de données dans PHPMyAdmin
- exporter le script SQL depuis MySQLWorkBench (fichier sql dans son repo aussi ^^)
- importer dans PHPMyAdmin le fichier SQL généré

## Conseils

### Docs

A revoir au préalable si besoin :

📚 Pour revoir la méthode, [la fiche récap conception bd](https://github.com/O-clock-Alumnis/fiches-recap/blob/master/gestion-projet/conception-bd.md)

### Rappels

Petit rappel des règles qu'on a vu jusqu'à présent:

- chaque champ contient une donnée atomique, unique (pas de données composées dans une case de la BD)
- pas de redondance (si une info se répète plusieurs fois dans une table, c'est qu'il faut modifier la structure)
- relation 1:n => clé étrangère (référence à l'identifiant d'une autre table) du côté de l'entité "1"
  Exemple: un post a un auteur, un auteur peut écrire plusieurs posts <=> un champ id_author dans la table posts, référence le champ id de la table users
- relation n:m => table de relation avec 2 clés étrangères, vers les id des entités "n" et "m"
  Exemple: un post peut être dans plusieurs catégories, une catégorie peut contenir plusieurs posts <=> une table posts_categories doit être créée, avec 2 champs id_post et id_category, chacun référençant respectivement la colonne id de la table concernée
