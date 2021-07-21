<?php
session_start();
require_once(__DIR__ . '/db_func.php');

if (empty($_GET))
    header('Location: index.php');

$pdo = dbconnect();

$qr = $pdo->prepare('SELECT degree FROM degrees WHERE id = ?');
$qr->execute([$_GET['id']]);
$tab = $qr->fetch(PDO::FETCH_ASSOC);
unlink(__DIR__ . 'degrees/' . $tab['degree']);

$qr = $pdo->prepare('DELETE FROM degrees WHERE id = ?');
$qr->execute([$_GET['id']]);

$_SESSION['flash'] = 'Votre diplôme a bien été supprimé.<br>';
$_SESSION['flash_type'] = 1;
header('Location: profil.php');
?>