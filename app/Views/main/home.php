<?php $this->layout('layout') ?>

<!-- Partie intermédiaire -->
<div class="container">
    <h1>A table</h1>
    <?php if ($connectedUser !== false) : ?>
        <h2>Bienvenue <?= $connectedUser->getUsername() ?> (<?= $connectedUser->getRoleId() ?>)</h2>
    <?php else : ?>
        <h2>Bienvenue chez MealOclock</h2>
    <?php endif; ?>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
<!-- Liste des communautés -->
<div class="container-fluid">
    <?php foreach ($communitiesList as $currentCommunity) : ?>
    <div class="row box">
        <div class="col-12 col-md-3">
            <img src="<?= $basePath ?><?= $currentCommunity->getImage() ?>" alt="" class="img-fluid">
        </div>
        <div class="col-12 col-md-6 box-content">
            <h2><?= $currentCommunity->getName() ?></h2>
            <p>
                <?= $currentCommunity->getDescription() ?>
            </p>
        </div>
        <div class="col-12 col-md-3 area">
            <h3>10 membres</h3>
            <p>
                créé par toto492@gmail.com
            </p>
            <div class="text-right">
                <a href="<?= $router->generate('community_community', ['id' => $currentCommunity->getId()]) ?>" class="btn btn-dark">Accéder</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    
    <h2>Les 5 prochains évènements</h2>
    <?php foreach ($eventsList as $currentEvent) : ?>
    <div class="row box">
        <div class="col-12 col-md-9 box-content">
            <h3><?= $currentEvent->getTitle() ?></h3>
            <p>
                <?= $currentEvent->getDescription() ?>
            </p>
        </div>
        <div class="col-12 col-md-3 area">
            <h4><?= $currentEvent->getFormattedDateEvent() ?></h4>
            <p>
                créé par toto492@gmail.com<br>
                <?= $currentEvent->getNbGuests() ?> invités
            </p>
            <div class="text-right">
                <a href="todo" class="btn btn-dark">Accéder</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
