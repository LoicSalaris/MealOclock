<?php

// Je n'oublie pas de configurer le namespace de la classe
// selon le PSR-4 configuré avec Composer
namespace MealOclock;

// Importe AltoRouter d'un autre namespace
use \AltoRouter;

class Application {
    
    // Je crée une propriété $router
    // pour pouvoir utiliser cette propriété dans toutes mes méthodes
    // Cette propriété n'a pas besoin d'être publique, car utile uniquement dans ma Class
    private $router;
    
    // Ma propriété contenant les données du fichier de config
    private $config;
  
    public function __construct() {
        // Récupération de la configuration
        $this->config = parse_ini_file(__DIR__.'/config.conf');
        //dump($this->config);exit;
        
        // J'instancie AltoRouter
        $this->router = new AltoRouter();
        
        // Si on bosse sous localhost, on doit indiquer à AltoRouter le chemin complet (tout ce qui est après "localhost" dans la barre d'adresse)
        // Sans slash de début mais avec slash de fin
        $this->router->setBasePath($this->config['BASEPATH']);
        
        // Je définis mes routes
        // (j'ai créé une méthode qui s'occupe de cela)
        $this->defineRoutes();
    }
    
    public function defineRoutes() {
        // - GET = méthode HTTP GET (ou POST ou les 2)
        // - "/" => correspond à l'URL (barre d'adresse)
        // - 'MainController#home'
        //  - 'MainController' = le nom du controller qui va s'occuper de cette page
        //  - '#' séparateur des 2 infos
        //  'home' méthode du controller qui va s'occuper de la page
        // - 'main_home' => le nom de cette route
        $this->router->map('GET', '/', 'MainController#home', 'main_home');
        $this->router->map('GET', '/cgu', 'MainController#cgu', 'main_cgu');
        $this->router->map('GET', '/contact', 'MainController#contact', 'main_contact');
        // Routes de Celine aka celberthon33
        $this->router->map('GET', '/faq', 'MainController#faq', 'main_faq');
        $this->router->map('POST', '/faq', 'MainController#faqPost', 'main_faqpost');
        $this->router->map('GET', '/legal', 'MainController#legal', 'main_legal');
        // BONUS : Implémenter la route "Community Show"
        // [i:id] => partie dynamique de l'URL
        // CommunityController
        $this->router->map('GET', '/community/[i:id]', 'CommunityController#community', 'community_community');
        // EventController
        $this->router->map('GET', '/events/[i:id]', 'EventController#show', 'event_show');
        $this->router->map('GET|POST', '/events/create', 'EventController#create', 'event_create');
        $this->router->map('GET', '/events', 'EventController#list', 'event_list');
        // UserController
        // => Si formulaire (et soumis en POST), alors route en GET & en POST => GET|POST
        $this->router->map('GET|POST', '/forgot_password', 'UserController#forgotPassword', 'user_forgotpassword');
        $this->router->map('GET', '/login', 'UserController#login', 'user_login');
        $this->router->map('POST', '/login', 'UserController#loginPost', 'user_loginpost');
        $this->router->map('GET', '/logout', 'UserController#logout', 'user_logout');
        $this->router->map('GET', '/profile', 'UserController#profile', 'user_profile');
        $this->router->map('GET', '/profile/communities', 'UserController#communities', 'user_communities');
        $this->router->map('GET', '/profile/communities/ajax', 'UserController#ajaxCommunities', 'user_ajaxcommunities');
        $this->router->map('GET|POST', '/profile/update', 'UserController#update', 'user_update');
        $this->router->map('GET|POST', '/signup', 'UserController#signup', 'user_signup');
        $this->router->map('GET|POST', '/update_password', 'UserController#updatePassword', 'user_updatepassword');
        
        // Admin from Frantz aka FrantzOclock
        $this->router->map('GET', '/admin-communities', 'CommunityController#list', 'community_list');
        $this->router->map('GET', '/admin-communities/create', 'CommunityController#create', 'community_create');
        $this->router->map('GET', '/admin-communities/[i:id]/update', 'CommunityController#update', 'community_update');
        $this->router->map('GET', '/admin-communities/[i:id]/delete', 'CommunityController#delete', 'community_delete');
        // Je crée une route pour une nouvelle page listant les utilisateurs
        $this->router->map('GET', '/admin/users', 'UserController#adminUserList', 'user_adminuserlist');
        
        // Route de test
        $this->router->map('GET', '/test', 'MainController#test', 'main_test');
    }

    public function run() {
        // Je fais le match d'une route par rapport à l'URL courante
        $match = $this->router->match();
        
        // dump($match);exit;
        
        // si on a un résultat (une route qui correspond)
        if ($match !== false) {
            // DISPATCH !
            // explode() = renvoie une tableau de string, à partir d'un autre string, en les séparant pour chaque #
            //dump($match['target']);
            $tmp = explode('#', $match['target']);
            //dump($tmp);
            // list permet d'affecter chaque élément du tableau $tmp dans des variables, en suivant l'ordre des variables
            list($controllerName, $methodName) = $tmp;
            //dump($controllerName);
            //dump($methodName);
            
            // Je construis le FQCN correspond au controller
            // On a besoin d'instancier la classe à partir de son FQCN ("chemin absolu")
            // car on fait un new $fqcnControllerName (PHP nous y oblige)
            $fqcnControllerName = '\MealOclock\Controllers\\'.$controllerName;
            
            // On instancie le controller
            $controller = new $fqcnControllerName($this);
            //dump($controller);
            
            // J'appelle la méthode
            $controller->$methodName($match['params']);
        }
        // Si ça match pas => Sonia-404
        else {
            // On envoie l'entete HTTP disant "Page not found"
            header("HTTP/1.0 404 Not Found");
            // On peut même afficher un truc !
            echo '404 made in Sonia<br>';
            exit;
        }
        
        // echo 'message lambda inutile mais indispensable!';
    }
    
    // Getter plus précis pour la propriété config
    public function getConfig($key) {
        // Si $key existe dans $this->config
        if (array_key_exists($key, $this->config)) {
            // Je ne retourne pas toute la propriété config
            // mais uniquement une des données du tableau
            return $this->config[$key];
        }
        return false;
    }
    
    // Getter simple
    public function getRouter() {
        return $this->router;
    }
}
