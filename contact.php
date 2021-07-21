<?php
require_once(__DIR__ . '/inc/header.php');

$err = '';

if (!empty($_POST)) {
    if (!isset($_POST['email']) || !isset($_POST['content']))
        $err .= 'Veuillez remplir tous les champs';
    $content = htmlentities(trim($_POST['content']));
    $email = htmlentities(trim($_POST['email']));
    if (empty($err)) {
        $pdo = dbconnect();
        $qr = $pdo->prepare('INSERT INTO contactmsg VALUES (NULL, ?, ?)');
        $qr->execute(array($email, $content));
        echo print_success('Votre message a bien été envoyé ! Nous vous répondrons aussi vite que possible. :)');
    }
}
require_once(__DIR__ . '/templates/contact.html');
require_once(__DIR__ . '/inc/footer.php');
