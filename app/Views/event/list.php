<?php $this->layout('layout') ?>

<!-- Partie intermédiaire -->
<div class="container">
    <h1>Evènements</h1>
</div>
<!-- Liste des communautés -->
<div class="container-fluid">
    <?php foreach ($eventList as $currentEvent) : ?>
    <div class="row box">
        <div class="col-12 col-md-3">
            <!-- on laisse l'image en dur pour ne pas trop complexifier -->
            <img src="<?= $basePath ?>assets/images/communities/vegan.jpg" alt="" class="img-fluid">
        </div>
        <div class="col-12 col-md-6 box-content">
            <h2><?= $currentEvent->getTitle() ?></h2>
            <p><?= $currentEvent->getDescription() ?></p>
        </div>
        <div class="col-12 col-md-3 area">
            <h3><?= $currentEvent->getFormattedDateEvent() ?></h3>
            <p>
                organisé par #todo
            </p>
            <div class="text-right">
                <a href="<?= $router->generate('event_show', ['id' => $currentEvent->getId()]) ?>" class="btn btn-dark">Détails</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
