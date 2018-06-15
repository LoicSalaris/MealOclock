<?php $this->layout('layout_connected') ?>

<p>Email : <?= $userModel->getEmail() ?></p>
<p>Username : <?= $userModel->getUsername() ?></p>

<div id="map" class="map"></div>
<script>
  var map;
  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 8
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXyv9VfmYc7DfpoC-vxXgtSo5sYt2LnuA&callback=initMap"
async defer></script>
