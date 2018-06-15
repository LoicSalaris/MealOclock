var app = {
  currentLatitude : 0,
  currentLongitude : 0,
  init: function() {
    console.log('init');
    
    // J'intercepte l'event "submit" du formulaire de login
    $('#formLogin').on('submit', app.submitFormLogin);
    
    // On teste la géolocalisation en JS
    if (typeof map != 'undefined') { // si l'objet map existe
    console.log(map);
      app.geoLocTest();
    }
  },
  submitFormLogin: function(evt) {
    // Ne pas oublier d'annuler le fonctionnement par défaut
    evt.preventDefault();
    
    // Je récupère toutes les données du formulaire
    var formData = $(this).serialize();
    
    console.log(formData);
    
    // Appel Ajax
    $.ajax({
      url: BASE_PATH+'login', // URL appelée par Ajax
      dataType: 'json', // le type de donnée reçue
      method: 'POST', // la méthode HTTP de l'appel Ajax
      data: formData // Les données envoyés avec l'appel Ajax
    }).done(function(response) {
      console.log(response);
      // Si tout est ok
      if (response.code == 1) {
        alert('Connexion réussie');
        // redirection vers l'url fournie
        location.href = response.url;
      }
      // Sinon, il y a eu des erreurs
      else {
        // Je vide la div des "erreurs"
        $('#errorsDiv').html('');
        // Je parcours la liste des erreurs
        response.errorList.forEach(function(value, index) {
          $('#errorsDiv').append(value+'<br>');
        });
        // J'affiche ma div cachée
        $('#errorsDiv').show();
      }
    }).fail(function() {
      alert('Error in ajax');
    });
  },
  geoLocTest: function() {
    var options = {
      enableHighAccuracy: true,
      timeout: 5000,
      maximumAge: 0
    };
    navigator.geolocation.getCurrentPosition(app.geoLocSuccess, app.geoLocFail, options);
  },
  geoLocSuccess: function (pos) {
    var crd = pos.coords;

    console.log('Votre position actuelle est :');
    console.log(`Latitude : ${crd.latitude}`);
    console.log(`Longitude: ${crd.longitude}`);
    console.log(`Plus ou moins ${crd.accuracy} mètres.`);
    
    // Centré au centre de la France, car pas géolocaliser :/
    map.setCenter({lat:crd.latitude, lng:crd.longitude});
  },
  geoLocFail: function(err) {
    console.warn(`ERROR(${err.code}): ${err.message}`);
  },
  getLatLongFromAddress: function() {
    // Je formate l'adresse pour qu'elle soit compréhensible par google
    var formattedAddress = currentEvent.address+', '+currentEvent.zipcode+', '+currentEvent.city+', France';
    
    $.ajax({
      url : 'https://maps.googleapis.com/maps/api/geocode/json',
      method: 'GET',
      dataType: 'json',
      data: {
        address: formattedAddress,
        key: 'AIzaSyAXyv9VfmYc7DfpoC-vxXgtSo5sYt2LnuA'
      }
    }).done(function(response) {
      console.log(response);
      
      // Je récupère les coordonnées GPS
      var currentLatitude = response.results["0"].geometry.location.lat;
      var currentLongitude = response.results["0"].geometry.location.lng;
      
      // Je centre la map sur la bonne adresse
      mapEvent.setCenter({lat: currentLatitude,lng: currentLongitude});
      mapEvent.setZoom(15);
      
      // On ajoute un marker (point sur la carte)
      var currentMarker = new google.maps.Marker({
        map : mapEvent,
        position: {lat: currentLatitude,lng: currentLongitude}
      });
      
    }).fail(function() {
      alert('Erreur ajax geocoding API');
    });
  },
  loadCommunitiesByUser: function() {
    // Appel ajax
    $.ajax({
      url: BASE_PATH+'profile/communities/ajax',
      method: 'GET',
      dataType: 'json'
    }).done(function(response) {
      console.log(response);
      if (response.length > 0) {
        response.forEach(function(currentValue) {
          $('#communitiesList').append(currentValue.name+'<br>');
        });
      }
      else {
        $('#communitiesList').append('Aucune communauté');
      }
    }).fail(function() {
      alert('fail');
    });
  }
};

$(app.init);
