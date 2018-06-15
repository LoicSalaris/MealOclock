<?php $this->layout('layout_connected') ?>

<div class="container">
    <h1>Mes communautés</h1>
</div>

<!-- Liste des communautés -->
<div class="container" id="communitiesList">
    
</div>


<!-- Utilisation de la méthode push de Plates pour ajouter du contenu à la section "js" du layout -->
<?php $this->push('js') ?>
<script>
// J'appelle la méthode de mon objet app
$(app.loadCommunitiesByUser);
</script>
<?php $this->end('js') ?>
