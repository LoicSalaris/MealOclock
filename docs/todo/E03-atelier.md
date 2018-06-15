# BDD d'une bibliothèque

### Énoncé

Une bibliothèque dispose d'une base de données reprenant des ouvrages, respectant les contraintes suivantes :

- Chaque **ouvrage** est doté d'un numéro l'identifiant au sein de la bibliothèque
  - il est caractérisé par :
    - son numéro ISBN
    - son titre
    - son éditeur
    - sa date de parution
    - ses auteurs (décrits par leurs numéro, nom et prénom)
    - ses références bibliographiques (les ouvrages qu'il cite)
- Un **exemplaire** est caractérisé par :
  - un numéro qui le distingue des autres exemplaires du même ouvrage
  - sa date d'acquisition
  - son état de vétusté
- Un **inscrit** est caractérisé par :
  - un numéro d'inscription
  - son nom
  - son prénom
  - son adresse
- Quand une personne emprunte un ouvrage, on retient :
  - la date de début d'un emprunt en cours
  - la date de retour prévue
- Quand l'exemplaire est restitué,
  - on conserve l'information relative à l'emprunt
  - on y ajoute la date de restitution
- On supposera qu'un même exemplaire ne peut être emprunté deux fois le même jour


### 1. Dictionnaire de données

Voilà les informations à noter pour définir le dictionnaire de données.  
Pour remplir le tableau, insérer le texte entre les `|`

| nom | type | description | entité | commentaire |
|-----|------|-------------|--------|-------------|
| exemple_de_champ |  |  |  |  |
|  |  |  |  |  |

On peut aussi utiliser Google Sheet :wink:

### 2. MCD

Le schéma entité-association / MCD de la base de données.  
Il permet de définir les cardinalités d'une relation entre les _entités_.

Pour définir les cardinalités, par exemple entre les entités **Panier** et **Produit**, on va se poser les questions suivantes.  
Les réponses sont un interval de valeurs : `0`, `1` ou `n`.

- un panier contient combien de produit(s) ? => entre `0` et `n`
- un produit est dans combien de panier ? => entre `0` et `n`
- => la relation entre **Panier** et **Produit** est `n:m` (valeurs max de chaque réponse => `n:n` mais dans ce cas, on dit `n:m`)

Au final, on obtient un schéma ressamblant à celui de la [fiche récap](https://github.com/O-clock-Alumnis/fiches-recap/blob/master/gestion-projet/conception-bd.md#3mod%C3%A8le-conceptuel-des-donn%C3%A9es--sch%C3%A9ma-entit%C3%A9-association)

### 3. MLD - Modèle Logique de données

- Simplifions-nous la vie, utilisons MySQLWorkBench
- Créer un `diagram`
- Ajouter toutes les entités sous forme de tables
- Ajouter les champs de chaque entité
- Penser à ajouter les champs suivants :
  - id
  - status (actif/désactivé => éviter de supprimer de la DB)
  - date_creation (permet de traquer la modification de la DB)
  - date_update
  - astuce, MySQLWorkBench propose des templates ^^
- Définir les relations entre chaque table
  - utiliser uniquement les boutons :
    - `1:1` non-identifying (pointillés)
    - `1:n` non-identifying (pointillés)
    - `n:m`
    - :warning: attention au sens des 2 clics
  - les Foreign Keys sont automatiquement générés :heart_eyes:

### 4. Exporter le MLD

- Exporter le schéma de MySQLWorkBench en PNG
  - Menu > File > Export > Export as PNG
- Exporter en SQL
  - Menu > File > Export > Forward Engineering SQL Create Script
  - Sélectionner un fichier SQL
  - Cocher uniquement :
    - _Skip creation of Foreign Keys_
    - _Ommit schema qualifier in Object Names_
    - _Generate INSERT statements for tables_
  - Next
  - Next
  - Finish

:tada: Et voilà, vous avez un fichier SQL que vous pouvez importer dans une base de données existante et vide :tada:
