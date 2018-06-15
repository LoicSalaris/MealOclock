<nav class="subnav">
<?php if ($connectedUser !== false) : ?>
    <!-- Sous-menu challenge E09 -->
    <div class="menu">
        <div class="menu-hover"><a href="<?= $router->generate('user_profile') ?>">Bonjour <?= $connectedUser->getUsername() ?></a></div>
        <div class="menu-hover"><a href="<?= $router->generate('user_communities') ?>">Mes communautés</a></div>
    </div>
<?php endif; ?>
</nav>
