<?php

namespace MealOclock\Controllers;

use MealOclock\Models\UserModel;
use MealOclock\Utils\User;

class UserController extends CoreController {
    public function signup() {
        // On sauvegarde la liste des erreurs dans un tableau
        $errorList = array();
        
        // Je distinggue le POST du GET
        if (!empty($_POST)) { // => POST
            // Je récupère les données
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';
            
            // Traiter les données
            $username = htmlentities($username); // encode les caractères HTML
            
            // Je valide les données
            if (empty($username)) {
                $errorList[] = 'Le nom d\'utilisateur doit être renseigné';
            }
            if (empty($email)) {
                $errorList[] = 'L\'adresse email doit être renseignée';
            }
            // Vérfification par un filtre de PHP que l'email est correct
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errorList[] = 'L\'adresse email n\'est pas correcte';
            }
            if (empty($password)) {
                $errorList[] = 'Le mot de passe doit être renseigné';
            }
            if ($password != $confirmPassword) {
                $errorList[] = 'Les 2 mots de passe doivent être égaux';
            }
            if (strlen($password) < 8) {
                $errorList[] = 'Le mot de passe doit faire au moins 8 caractères';
            }
            
            // Si tout est ok (aucune erreur)
            if (count($errorList) == 0) {
                // TODO vérifier que username n'existe pas déjà
                // TODO vérifier que email n'existe pas déjà
                
                // J'encode, je hash le mot de passe avant de le stocker en DB
                $hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Pour sauvegarder en DB, je dois d'abord créer le Model
                $userModel = new UserModel();
                // Puis donner une valeur à chaque propriété (besoin des setters)
                $userModel->setUsername($username);
                $userModel->setEmail($email);
                $userModel->setPassword($hash);
                $userModel->setRoleId(2); // 2 => membre
                $userModel->setStatus(1); // 1 => actif
                
                // Je peux sauvegarder le model
                $insertedRows = $userModel->save();
                
                if ($insertedRows > 0) {
                    // Je peux rediriger car tout est ok
                    die('ok => redirection');
                    // TODO redirection
                }
                else {
                    $errorList[] = 'Erreur dans l\'ajout à la DB';
                }
            }
        }
        
        // J'affiche le rendu de ma template
        echo $this->templates->render('user/signup', [
            'errorList' => $errorList
        ]);
    }
    
    public function login() {
        // J'affiche le rendu de ma template
        echo $this->templates->render('user/login');
    }
    
    // Méthode traitant les données du formulaire de login envoyés en Ajax (POST)
    // L'appel Ajax s'attend à du JSON en retour => afficher du JSON
    public function loginPost() {
        // On sauvegarde la liste des erreurs dans un tableau
        $errorList = array();
        
        // Je récupère les données
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? trim($_POST['password']) : '';
        
        // Je valide les données
        if (empty($email)) {
            $errorList[] = 'L\'adresse email doit être renseignée';
        }
        // Vérfification par un filtre de PHP que l'email est correct
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errorList[] = 'L\'adresse email n\'est pas correcte';
        }
        if (empty($password)) {
            $errorList[] = 'Le mot de passe doit être renseigné';
        }
        
        // Si tout est ok (aucune erreur)
        if (count($errorList) == 0) {
            // Je récupère le user correspondant au mot de passe
            // la méthode renvoie false si aucun résultat
            $userModel = UserModel::findByEmailOrUsername($email);
            // dump($userModel);exit;
            
            // Si j'ai un résultat sous forme d'objet
            if ($userModel !== false) {
                // Alors je test le mot de passe
                if (password_verify($password, $userModel->getPassword())) {
                    // On stocke le user en session
                    // C'est suffisant pour connecter l'utilisateur
                    // Par contre, on doit convertir l'objet en StdClass
                    // $_SESSION['user'] = $userModel;
                    User::setUser($userModel);
                    //print_r($_SESSION['user']);
                    
                    // On affiche un JSON disant que tout est ok
                    $this->sendJSON([
                        'code' => 1,
                        'url' => $this->router->generate('main_home')
                    ]);
                }
                else {
                    $errorList[] = 'Le mot de passe est incorrect pour cet email';
                }
            }
            else {
                $errorList[] = 'Aucun compte n\'a été trouvé pour cet email';
            }
        }
        
        // J'envoie (j'affiche) les erreurs au format JSON
        $this->sendJSON([
            'code' => 2,
            'errorList' => $errorList
        ]);
    }
    
    public function adminUserList() {
        // ici je teste le role
        if (User::isAdmin()) {
            // Je veux tous les utilisateurs en DB
            $userList = UserModel::findAll();
            
            // J'affiche le retour de la template
            echo $this->templates->render('user/admin_user_list', [
                'userList' => $userList
            ]);
        }
        else {
            // 403 - forbidden
            $this->sendHttpError(403);
        }
    }
    
    public function profile() {
        if (User::isConnected()) {
            // User connecté
            $connectedUser = User::getUser();
            // récupère les données sur l'utilisateur connecté
            // Je redemande à la DB les données car les données en session datent du moment où l'utilisateur s'est connecté
            $userModel = UserModel::find($connectedUser->getId());
            
            echo $this->templates->render('user/profile', [
                'userModel' => $userModel
            ]);
        }
        else {
            // Utilisateur non connecté => redirection vers la page de connexion
            $this->redirectToRoute('user_login');
        }
    }
    
    // challenge E09
    public function logout() {
        // On doit être connecté pour se déconnecter
        if (User::isConnected()) {
            // On appelle la méthode de la librairie User, permettant de déconnecter
            User::logout();
            
            // Puis je redirige vers la home
            $this->redirectToRoute('main_home');
        }
        else {
            // Utilisateur non connecté => redirection vers la page de connexion
            $this->redirectToRoute('user_login');
        }
    }
    
    public function communities() {
        // J'affiche le retour de la template
        echo $this->templates->render('user/communities');
    }
    
    public function ajaxCommunities() {
        // Si on a un user connecté
        if (User::isConnected()) {
            // Récupérer l'utilisateur connecté
            $user = User::getUser();
            
            // récupération des communautés
            $communitiesList = $user->getCommunities();
            
            self::sendJSON($communitiesList);
        }
        echo '0';
    }
}
