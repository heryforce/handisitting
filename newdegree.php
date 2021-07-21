<?php
session_start();
require_once(__DIR__ . '/db_func.php');
require_once(__DIR__ . '/functions.php');

if ($_FILES['degree']['size'] != 0) {
    $err = '';
    var_dump($_FILES);

    if ($_FILES['degree']['type'] != 'application/pdf')
        $err .= 'Le fichier doit être au format .pdf.<br>';

    if (empty($err)) {
        $file_name = uniqid(rand()) . $_SESSION['mail'] . '.pdf';
        if (move_uploaded_file($_FILES['degree']['tmp_name'], __DIR__ . '/degrees/' . $file_name)) {
            $pdo = dbconnect();
            $qr = $pdo->prepare('INSERT INTO degrees VALUES (NULL, ?, ?)');
            $qr->execute([$_SESSION['id'], $file_name]);
            $_SESSION['flash'] = 'Votre diplôme a bien été ajouté !';
            $_SESSION['flash_type'] = 1;
            header('Location: profil.php');
        } else
            echo print_error('Error during upload<br>');
    }
} else
    header('Location: profil.php');
