<?php

namespace MealOclock\Controllers;

// J'importe les classes d'autres namespace
use MealOclock\Models\CommunityModel;

// Pas besoin d'importer CoreController, la classe est dans le même namespace
class CommunityController extends CoreController {
    public function community($allParams) {
        //dump($allParams);
        
        // Je récupère l'id sous forme de int
        $id = (int) $allParams['id'];
        //$id = intval($allParams['id']);
        //$
        // J'appelle la méthod find()
        $community = CommunityModel::find($id);
        //dump($community);exit;
        
        // 1ère façon de concaténer
        //echo 'Vous souhaitez consulter la catégorie n°'.$allParams['id'].'<br>';
        // 2e façon de concaténer (généralement + facile, mais faut pas oublier les { } )$id = (int) $allParams['id'];
        //echo "Vous souhaitez consulter la catégorie n°{$allParams['id']}<br>";
        
        // On utilise désormais un moteur de templates !
        // convention de nommage des templates :
        //   - nom du controller
        //   - /
        //   - nom de la méthode
        echo $this->templates->render('community/community', [
            'communityId' => $id, // => $communityId dans la template
            'currentCommunity' => $community // $currentCommunity
        ]);
    }
    
    // Route /admin-communities
    public function list() {
        
    }
    
    // Route /admin-communities/create
    public function create() {
        
    }
    
    // Route /admin-communities/[i:id]/update
    public function update() {
        
    }
    
    // Route /admin-communities/[i:id]/delete
    public function delete() {
        
    }
}
