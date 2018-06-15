<?php

namespace MealOclock\Controllers;

use MealOclock\Models\EventModel;

class EventController extends CoreController {
    public function show($allParams) {
        // Je récupère l'id sous forme de int
        $id = (int) $allParams['id'];
        
        // Je récupère l'objet EventModel correspindant à l'ID
        $eventModel = EventModel::find($id);
        
        // appel à la view
        // convention de nommage des templates :
        //   - nom du controller
        //   - /
        //   - nom de la méthode
        echo $this->templates->render('event/show', [
            'currentEvent' => $eventModel // => $currentEvent dans la template
        ]);
    }
    
    public function create() {
        // appel à la view
        // convention de nommage des templates :
        //   - nom du controller
        //   - /
        //   - nom de la méthode
        echo $this->templates->render('event/create');
    }
    
    public function list() {
        // Je récupère la liste des events dans la DB
        $eventList = EventModel::findAll();
        
        // appel à la view
        // convention de nommage des templates :
        //   - nom du controller
        //   - /
        //   - nom de la méthode
        echo $this->templates->render('event/list', [
            'eventList' => $eventList
        ]);
    }
}
