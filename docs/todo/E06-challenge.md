# Challenge Models

## Objectif

L'objectif est de créer les méthodes nécessaires pour gérer les données sur la table `event`

### Astuces

- regarder le travail effectué dans oKanban (`ListModel`)

## Challenge

- créer les 4 méthodes représentant le CRUD sur une table :
  - Create
  - Read
  - Update
  - Delete
- les 4 méthodes seront :
  - `insert()`
  - `find($id)`
  - `update()`
  - `delete()`
- Attention, lors d'une insertion, la propriété `id` doit récupérer la valeur du champ `id` auto-incrémenté

<details><summary>Requête d'insertion (Create)</summary>

```
INSERT INTO `event` (`title`, `description`, `price`, `date_event`, `address`, `zipcode`, `city`, `nb_guests`, `is_virtual`, `virtual_address`, `status`, `date_inserted`, `date_updated`, `community_id`, `user_id`) VALUES ("Titre","Description",14.9,"2018-04-28","25 rue Toto","75008","PARIS",12, 0, "", 1, NOW(), NOW(), 1, 1)
```

</details>

<details><summary>Requête de lecture (Read)</summary>

```
SELECT id, `title`, `description`, `price`, `date_event`, `address`, `zipcode`, `city`, `nb_guests`, `is_virtual`, `virtual_address`, `status`, `date_inserted`, `date_updated`, `community_id`, `user_id`
FROM `event`
WHERE id = 1
```

</details>

<details><summary>Requête de mise à jour (Update)</summary>

```
UPDATE `event`
SET `title` = "Titre",
`description` = "Description",
`price` = 14.9,
`date_event` = "2018-04-28",
`address` = "25 rue Toto",
`zipcode` = "75008",
`city` = "PARIS",
`nb_guests` = 12,
`is_virtual` = 0,
`virtual_address` = "",
`status` = 1,
`date_inserted` = NOW(),
`date_updated` = NOW(),
`community_id` = 1,
`user_id` = 1
WHERE id = 1
```

</details>

<details><summary>Requête de suppression (Delete)</summary>

```
DELETE FROM `event` WHERE id = 1
```

</details>

## Script de test

- mapper une nouvelle route `/test` qui va appeler une méthode `test` dans le `MainController`
- dans cette méthode :
  - insérer une ligne dans la table `event` grâce au `EventModel`
  - afficher l'objet en résultant (`dump()`)
  - mettre à jour la ligne dans la table `event` grâce au `EventModel`
  - lire l'objet pour l'id
  - afficher l'objet en résultant (`dump()`)
  - supprimer la ligne dans la table `event` grâce au `EventModel`
  - lire à nouveau l'objet pour l'id
  - condition si on a au moins 1 résultat :
    - => afficher 'suppression chouée'
    - sinon => afficher "suppression réussie de l'id #XX"
- Infos :
  - le champ `id` permet d'identifier de façon sûre, certaine et unique une ligne dans une table
  - à chaque rechargement de la page, le script s'exécutera à nouveau en entier (nouvel id, etc.)

## Bonus

- regarder la méthode `prepare` beaucoup + sécurisée :
  - http://php.net/manual/fr/pdo.prepare.php
  - et les exemples http://php.net/manual/fr/pdo.prepare.php#refsect1-pdo.prepare-examples
  - mais surtout `bindValues` http://php.net/manual/fr/pdostatement.bindvalue.php
  - et les exemples avec `prepare` et `bindValues`
  - http://php.net/manual/fr/pdostatement.bindvalue.php#refsect1-pdostatement.bindvalue-examples
- Coder le _Model_ **MemberModel**
- Coder le _Model_ **UserModel**

## Bonus de la mort 💀

- changer notre code => utiliser toujours `prepare` dès qu'il y a des données dans la requête (`insert`, `update`, `delete`)
