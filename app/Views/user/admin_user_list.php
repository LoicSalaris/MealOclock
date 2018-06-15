<?php $this->layout('layout') ?>

<h2>Liste des utilisateurs</h2>

<?php if (!empty($userList)) : ?>
    <?php foreach ($userList as $currentUserModel) : ?>
        <?= $currentUserModel->getEmail() ?><br>
    <?php endforeach; ?>
<?php endif; ?>
