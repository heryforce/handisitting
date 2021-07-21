<?php
require_once('db_func.php');
require_once('functions.php');
?>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="css/custom.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur Handisitting !</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <span class="navbar-brand">Handisitting</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="recherche.php">Recherche</a>
                        </li>
                        <?php session_start();
                        echo empty($_SESSION) ?
                            '<li class="nav-item"><a class="nav-link" href="connexion.php">Se connecter</a></li> <li class="nav-item"><a class="nav-link" href="inscription.php">S\'inscrire</a></li>' :
                            '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bonjour ' . $_SESSION['firstName'] . ' !</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profil.php">Mon profil</a></li>
                        <li><a class="dropdown-item" href="msgs.php">Ma messagerie</a></li>
                        <li><a class="dropdown-item" href="deconnexion.php">Me déconnecter</a></li>
                    </ul>
                </li>'
                        ?>
                    </ul>
                </div>
        </nav>
        </div>
    </header>
    <main>