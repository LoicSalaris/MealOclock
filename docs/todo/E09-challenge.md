# Challenge Connexion & Role

## Objectifs

L'objectif est de modifier la barre de navigation en fonction de l'utilisateur connecté.

## Astuces

- `$connectedUser` existe dans les templates, on l'a mis à disposition via `->addData` dans le _CoreController_

## Challenge

[Ce document PDF](E09-layout.pdf) fourni des indications sur la navigation de _MealOclock_.

### Inscription => Déconnexion

Si connecté, le bouton "Inscription" devient "Déconnexion".

- ajouter la méthode `logout()` s'occupant de déconnecter de l'utilisateur dans `\MealOclock\Utils\User`
- faire en sorte que l'utilisateur se déconnecte en cliquant sur ce lien
- puis le rediriger vers la home

### Connexion => Mon compte

Si connecté, le bouton "Connexion" devient "Mon compte" et permet d'aller sur son profil.

### Sous-menu "Mon compte"

Si connecté, dans les pages de la partie "Mon compte" (profil par exemple), afficher un sous-menu comme décrit dans le PDF fourni.

Le sous-menu contient :

- "Bonjour xxx" avec le nom de l'utilisateur : ce n'est pas un bouton cliquable, juste un texte qui dit bonjour ^^
- "Mes communautés" : Bouton cliquable qui mène vers une page qui liste les communautés auxquelles fait parti l'utilisateur

## Bonus _GoogleMaps_

Lire la document sur [GoogleMaps Javascript API](https://developers.google.com/maps/documentation/javascript/tutorial?hl=fr).  
Lors de la dernière journée, nous allons afficher la page d'un évènement avec une carte pointant le lieu de l'évènement :tada:

## Bonus de la mort 💀

Certaines pages du site peuvent être mises en place (partie "publique" ou partie "membre") :  

- on a toutes les routes configurées
- on a le code récupérant les données de la DB
- il reste donc :
  - les méthodes de _Controller_
  - les _Views_
- Let's go ! :muscle:
