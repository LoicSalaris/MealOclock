<?php

namespace MealOclock\Controllers;

use MealOclock\Utils\User;

// Classe "coeur" des Controllers
// sera héritée par les controllers pour hériter :
//  - de ses propriétés
//  - de ses méthodes
// abstract = Classe abstraite
// => interdiction d'instancier cette classe
abstract class CoreController {
    // Je stocke le moteur de template dans une propriété de la classe pour que ce soit accessible à toutes ses méthodes
    protected $templates;
    
    // Je stocke l'objet AltoRouter dans une propriété de la classe pour que ce soit accessible à toutes ses méthodes (ettous ses enfants)
    protected $router;
        
    // $app = Application passé en paramètre lors du "dispatch"
    public function __construct($app) {
        // Je crée une instance du moteur de Templates
        $this->templates = new \League\Plates\Engine(__DIR__.'/../Views');
        
        // Je récupère le router qui est dans $app
        $this->router = $app->getRouter();
        
        // Je définis des données utiles pour toutes les templates
        $this->templates->addData([
            'title' => 'MealOclock', // => $title
            'machins' => 'Rémy',
            'basePath' => $app->getConfig('BASEPATH').'/', // => $basePath
            'router' => $this->router, // => $router
            'connectedUser' => User::getUser() // $connectedUser
        ]);
    }
    
    // Méthode permettant d'afficher le code HTML en passant par le système de views
    public function render() {
        // TODO
    }
    
    // Méthode permettant d'afficher un résultat sous forme de JSON
    // (utile quand la page est appelée via Ajax)
    public static function sendJSON($data) {
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);
        exit;
    }
    
    // Méthode permettant d'envoyer un code HTTP dans l'entête de réponse HTTP
    // on peut en plus afficher un message ou du code HTML
    public function sendHttpError($code, $source='') {
        if ($code == 403) {
            header('HTTP/1.0 403 Forbidden');
            echo $source;
            exit;
        }
    }
    
    // Méthode permettant de rediriger vers une URL passée en paramètre
    public function redirect($url) {
        header('Location: '.$url);
        exit;
    }
    
    // Méthode permettant de rediriger vers une route de l'application
    public function redirectToRoute($routeName, $params=array()) {
        $this->redirect($this->router->generate($routeName, $params));
    }
}
