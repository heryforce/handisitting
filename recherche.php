<?php
require_once(__DIR__ . '/inc/header.php');

if (!empty($_POST)) {
    $city = htmlentities(trim($_POST['city']));

    $pdo = dbconnect();

    $qr = $pdo->prepare('SELECT * FROM members WHERE city like ? AND role = ?');
    $qr->execute([$city, $_POST['role']]);
    $arr = $qr->fetchAll(PDO::FETCH_ASSOC);
    if(empty($arr))
    echo print_warning('Il n\'y a malheureusement aucun membre dans cette ville... pour le moment !');
}

require_once(__DIR__ . '/templates/recherche.phtml');
require_once(__DIR__ . '/inc/footer.php');
