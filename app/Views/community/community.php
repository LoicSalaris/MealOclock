<?php $this->layout('layout') ?>

<h1><?= $currentCommunity->getName() ?></h1>

<p>Vous souhaitez consulter la catégorie n°<?= $communityId ?></p>

<p><?= $currentCommunity->getDescription() ?></p>

<?php dump($currentCommunity); ?>
