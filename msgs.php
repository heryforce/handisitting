<?php
require_once(__DIR__ . '/inc/header.php');

if (empty($_SESSION))
    header('location: index.php');

if (!empty($_GET) && $_GET['id'] == '')
    header('location: msgs.php');

$convos = getConvos();

if (!empty($_GET['id'])) {
    if ($_GET['id'] === $_SESSION['id'])
        header('location: profil.php');

    $thisConvo = getConvo($_GET['id']);

    if (empty($thisConvo)) {
        //si la conv n'existe pas, créer la conv
        $thisConvo = createAndGetConvo($_GET['id']);
    }

    $msgs = getMsgs($thisConvo['id']);
    $whoTo = getMember($_GET['id']);
    $bio = $whoTo['bio'];
    if (iconv_strlen($bio) > 50) {
        $bio = substr($whoTo['bio'], 0, 50);
        $bio .= $bio . '...';
    }

    if (!empty($_POST)) {
        $newMsg = htmlentities(trim($_POST['message']));
        sendMsg($thisConvo['id'], $newMsg);
    }
}

require_once(__DIR__ . '/templates/msgs.phtml');
require_once(__DIR__ . '/inc/footer.php');
