<!-- Titre de la page -->
<?php $title = "StagEureka - Accueil"; ?>

<!-- Contenu de la page -->
<?php ob_start(); ?>
<h1>StagEureka</h1>
<p>Bienvenue</p>
<?php $content = ob_get_clean(); ?>

<!-- On appelle le layout -->
<?php require('layout.php') ?>