<?php

namespace MealOclock\Controllers;

// J'importe les classes se trouvant dans un autre namespace
use MealOclock\Models\CommunityModel;
use MealOclock\Models\EventModel;
use MealOclock\Models\CoreModel;
use MealOclock\Models\UserModel;

// Pas besoin d'importer CoreController, la classe est dans le même namespace
class MainController extends CoreController {
    public function home() {
        // Je demande au CommunityModel de me donner la liste de toutes les communautés
        // Je n'ai pas besoin d'instancier le model
        // car la méthode est static
        // J'appelle la méthode findAll
        $communitiesList = CommunityModel::findAll();
        // dump($communitiesList);exit;
        // J'appelle la méthode findAll
        // $usersList = UserModel::findAll();
        // dump($usersList);exit;
        // $eventsList = EventModel::findAll();
        // dump($eventsList);
        // exit;
        
        // Je récupère les 5 prochaines évènements
        $eventsList = EventModel::getNextFive();
        // dump($eventsList);exit;
        
        // J'affiche le rendu d'un template
        // convention de nommage des templates :
        //   - nom du controller
        //   - /
        //   - nom de la méthode
        // Je fournis la donnée "name" et sa valeur "Ben" à la template
        echo $this->templates->render('main/home', [
            'name' => 'Ben', // => $name dans la template
            'communitiesList' => $communitiesList, // $communitiesList
            'eventsList' => $eventsList
        ]);
    }
    
    public function cgu() {
        // J'affiche le rendu d'un template
        echo $this->templates->render('main/cgu');
    }
    
    public function legal() {
        // J'affiche le rendu d'un template
        echo $this->templates->render('main/legal');
    }
    
    public function faq() {
        // J'affiche le rendu d'un template
        echo $this->templates->render('main/faq');
    }
    
    // Méthode ne gérant que la soumission du formulaire en POST de la page FAQ
    public function faqPost() {
        // Si form soumis
        if (!empty($_POST)) {
            //dump($_POST);exit;
            $postData = isset($_POST['fx']) ? $_POST['fx'] : '';
            // Todo traiter le formulaire
            
            $communityModel = new CommunityModel();
            $communityTest = $communityModel->find($postData);
            dump($communityTest);
        }
    }
    
    // Script de test (Challenge E06)
    public function test() {
        
        // J'affiche la valeur de la constante TABLE_NAME de la classe CommunityModel
        echo CommunityModel::TABLE_NAME.'<br>';
        
        // Tentative de création d'un objet UserModel
        //$userModel = new UserModel();
        
        // Tentative de création d'un objet CoreModel
        //$coreModel = new CoreModel();
        
        // Je crée l'instance du model
        $eventModel = new EventModel();
        // Je définis les propriétés du model
        $eventModel->setTitle('titre');
        $eventModel->setDescription('mon évènement de test');
        $eventModel->setDateEvent('2018-06-10 14:00:00'); // 10 juin 2018 à 14h
        $eventModel->setPrice(14.9);
        $eventModel->setAddress("12 rue de la paix");
        $eventModel->setZipcode("75008");
        $eventModel->setCity("PARIS");
        $eventModel->setNbGuests(10);
        $eventModel->setIsVirtual(2);
        $eventModel->setVirtualAdress('');
        $eventModel->setStatus(1);
        $eventModel->setCommunityId(1);
        $eventModel->setUserId(1);
        
        // Debug
        dump($eventModel);
        
        // J'insère en DB
        $insertedRows = $eventModel->save();
        
        if ($insertedRows > 0) {
            echo '$eventModel inséré<br>';
            // Debug
            dump($eventModel);
        }
        else {
            echo 'erreur dans l\'insertion<br>';
            exit;
        }
        
        // Je fais la mise à jour
        $eventModel->setTitle('title modifié');
        
        // Debug
        dump($eventModel);
        
        // J'update la DB
        $updatedRows = $eventModel->save();
        
        if ($updatedRows > 0) {
            echo '$eventModel mis à jour<br>';
            // Debug
            dump($eventModel);
        }
        else {
            echo 'erreur dans la mise à jour<br>';
            exit;
        }
        
        // Je récupère un model pour l'id donné
        $id = $eventModel->getId();
        
        $lastEventModel = $eventModel->find($id);
        echo 'dump de la récupération à partir de l\'id<br>';
        dump($lastEventModel);
        
        // Suppresion
        $deletedRows = $eventModel->delete();
        
        if ($deletedRows > 0) {
            echo '$eventModel supprimé<br>';
        }
        else {
            echo 'erreur dans la suppression<br>';
            exit;
        }
        
        // Je récupère un model pour l'id donné
        $lastEventModel = $eventModel->find($id);
        echo 'dump de la récupération à partir de l\'id<br>';
        dump($lastEventModel);
    }
}
