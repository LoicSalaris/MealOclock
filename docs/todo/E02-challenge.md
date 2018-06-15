# 💀 Challenge E02 : créer la structure de base du projet 💀

## Objectif

**Construire un squelette pour la partie FrontController/Controller de l'application**

Pour montrer que votre architecture est fonctionnelle, il suffira que le projet propose 2 routes :

- `/`, la page d'accueil, qui affichera "Hello World !" (très original).
- `/community/[i:id]` la page d'une communauté, qui affichera "Vous souhaitez consulter la catégorie n° $id" (où $id est la valeur saisie dans l'url)

(cette tache correspond à la première User Story de validation technique).

## Etapes

### Créer la base de votre application

- créez le **répertoire racine** de votre application, qui contiendra toutes vos classes pour mealOclock. Nommez le comme vous souhaitez
- créer la classe qui joue le rôle de FrontController : `Application`  
  - créer la méthode `run` qui doit afficher un message (peu importe) qui permet de vérifier qu'elle est bien éxécutée
- créer un fichier `index.php` qui instancie et appelle la méthode "run" de votre classe `Application`

### Configurer Composer pour l'auto-chargement de vos classes

- créer le fichier `composer.json` (manuellement ou avec `composer init`) à la racine du projet
- configurez le dossier contenant vos classes et le namespace `Mealoclock` pour votre application
- éxécuter `composer install` dans le terminal
- tester votre config : visiter le projet et vérifier que la méthode `run()` de l'application est bien éxécutée.
  - _n'oubliez pas d'inclure le fichier `vendor/autoload.php` de composer dans votre fichier index_
  - _n'oubliez pas de placer vos classes dans le bon namespace_

### Installer AltoRouter

- Passer par composer pour installer [AltoRouter](http://altorouter.com)
- <details><summary>Spoiler</summary>
  `composer require altorouter/altorouter`
  </details>

### Implémenter les méthodes de la classe Application

- à l'instanciation de la classe `Application` (dans son constructeur, donc)
  - instancier le routeur
  - configurer le routeur instancié
- à l'appel de la méthode `run`
  - le routeur doit faire le "match"
  - puis le routeur doit faire le "dispatch"
  - [rappel MVC](https://betterexplained.com/wp-content/uploads/rails/mvc-rails.png)
  - le code a déjà été fait dans oKanban, mais peut-être pas dans un objet `Application`

### Implémentez la routes de test et le controller correspondant

- configurez la route `/` avec AltoRouter
- créer un Controller de base, le `MainController`, à la bonne place dans l'arborescence
- créer la méthode `home()` dans le `MainController`
  - elle doit afficher "Hello World"

NB : pour l'instant, on veut uniquement s'assurer que le routage fonctionne, donc les méthodes de controlleur doivent juste afficher le résultat attendu avec `echo`

### BONUS : Implémenter la route "Community Show"

- configurez la route `/community/[i:id]`
- créer le `CommunityController`
  - créer la méthode `show($...)`
  - elle doit afficher "Vous souhaitez consulter la catégorie n° $id" (où $id est la valeur saisie dans l'url)


### BONUS

Pour aller plus loin,
- vous pouvez mettre en place un `CoreController` qui sera hérité par tous les Controller
- dans cette classe `CoreController`, regroupez les méthodes et/ou propriétés qui seront utiles à tous les Controllers...
