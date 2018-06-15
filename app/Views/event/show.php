<?php $this->layout('layout') ?>

<!-- Partie intermédiaire -->
<div class="container">
    <h1>&Eacute;vènement #<?= $currentEvent->getId() ?></h1>
    
    <h2><?= $currentEvent->getTitle() ?></h2>
    <p>
        <?= $currentEvent->getDescription() ?>
    </p>
    <p>
        le <?= $currentEvent->getFormattedDateEvent() ?><br>
        à l'adresse suivante :<br>
        <!-- Si l'event n'est pas virtuel -->
        <?php if ($currentEvent->getIsVirtual()) : ?>
            <?= $currentEvent->getVirtualAdress() ?>
        <?php else : ?>
            <?= $currentEvent->getAddress() ?><br>
            <?= $currentEvent->getZipcode() ?><br>
            <?= $currentEvent->getCity() ?><br>
        <?php endif; ?>
    </p>
</div>

<!-- Si l'event n'est pas virtuel -->
<?php if ($currentEvent->getIsVirtual() == false) : ?>
<div id="mapEvent" class="map"></div>
<script>
  var mapEvent;
  function initMap() {
    mapEvent = new google.maps.Map(document.getElementById('mapEvent'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 8
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXyv9VfmYc7DfpoC-vxXgtSo5sYt2LnuA&callback=initMap"
async defer></script>
<?php endif; ?>

<!-- Utilisation de la méthode push de Plates pour ajouter du contenu à la section "js" du layout -->
<?php $this->push('js') ?>
<script>
var currentEvent = {
    address : "<?= $currentEvent->getAddress() ?>",
    zipcode: "<?= $currentEvent->getZipcode() ?>",
    city: "<?= $currentEvent->getCity() ?>"
};
// J'appelle la méthode de mon objet app
$(app.getLatLongFromAddress);
</script>
<?php $this->end('js') ?>
