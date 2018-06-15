# Challenge E01 : nav et liste de routes

## Objectif

Imaginer l'appli qui va être développée et réviser le fonctionnement d'AltoRouter

## Pré-requis

- Si vous ne vous êtes pas documentés sur
  - Composer (à quoi ça sert)
  - AltoRouter (comment ça marche)
  - Plates (rapidement)
- avant le lancement du projet, c'est le moment de regarder, demain on commence le setup de l'archi technique

## Instructions

- Vous avez été chargé de travailler sur le paramétrage d'AltoRouter. Certes, toute l'architecture n'est pas en place, mais on sait déjà ce qu'on a à faire.
- À partir des documents, essayez de préparer le développement : faites une liste (exploratoire) des routes nécessaires pour l'application. (consultez particulièrement le plan de navigation prévu, et la liste des fonctionnalités, essayez de ne rien oublier).  
- Une route peut être celle d'une page précise (ex: home, contact) ou celle d'un type de page (ex: "page catégorie", même présentation pour toutes les catégories d'un site).  
- Pour les pages contenant un formulaire, autrement dit _les routes pour lesquelles une action autre que la consultation est possible pour l'utilisateur_ : inscription, recherche, envoi d'un message... souvenez vous que souvent, la méthode `POST` est nécessaire.
- Spécifiez (autant que possible, il s'agit d'une première exploration) pour chaque route :
  - Un titre
  - une description (ex : page d'accueil, pas de paramètre, c'est la page de présentation, contiendra les 5 prochains évènements et les communautés)
  - methode(s) (`GET`, `POST`, `GET|POST`)
  - l'URL (avec si besoin la description des paramètres dynamiques du l'URL)

Exemple :

```
title : Catégorie XXX
description : page présentant le détail d'une catégorie : image, description longue, 3 meilleurs articles.
method: `GET`,
url: `/category/[i:id]`,
comment : le paramètre id est l'identifiant de la catégorie à afficher
```

Vous pouvez mettre ça dans un fichier .md directement dans votre repo de travail.  
:eye: **Vous pouvez également utiliser un fichier Google Sheets** (que vous pouvez créer dans votre Google Drive, drive.google.com) si vous préférez utiliser un tableur.  

## Bonus

- Pour chaque route, vous pouvez définir le nom du _Controller_
- Pour chaque route, vous pouvez définir le nom de la méthode de _Controller_
