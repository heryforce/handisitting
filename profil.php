<?php
require_once(__DIR__ . '/inc/header.php');

if (empty($_SESSION))
    header('Location: connexion.php');

if (!empty($_SESSION['flash'])) {
    echo checkAndPrint($_SESSION['flash'], $_SESSION['flash_type']);
    unset($_SESSION['flash']);
    unset($_SESSION['flash_type']);
}

$pdo = dbconnect();

$qr = $pdo->prepare('SELECT * FROM degrees WHERE sitterId = ?');
$qr->execute([$_SESSION['id']]);
$degs = $qr->fetchAll(PDO::FETCH_ASSOC);

if (!empty($_POST)) {
    $upd = '';
    $err = '';
    $upd .= "UPDATE members SET ";

    if (
        !empty($_POST['bio']) ||
        !empty($_POST['phone']) ||
        !empty($_POST['mail'])
    ) {
        if (!empty($_POST['bio']))
            $upd .= 'bio = "' . htmlspecialchars(trim($_POST['bio'])) . '", ';

        if (!empty($_POST['phone'])) {
            if (preg_match('/^[0-9]{10}+$/', $_POST['phone']) !== 1)
                $err .= 'Erreur dans le numéro de téléphone.<br>';
            $upd .= 'phone = "' . $_POST['phone'] . '", ';
        }

        if (!empty($_POST['mail'])) {
            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL))
                $err .= 'Veuillez utiliser une adresse mail correcte.<br>';
            $upd .= 'mail = "' . $_POST['mail'] . '"';
        }

        if (substr($upd, -2) == ', ') {
            $upd = substr($upd, 0, iconv_strlen($upd) - 2);
            if (substr($upd, -1) != '"')
                $upd .= '"';
        }

        $upd .= ' where id = ' . $_SESSION['id'];
        if (empty($err)) {
            updateMember($upd);
            $tab = getMember($_SESSION['id']);
            $_SESSION['bio'] = $tab['bio'];
            $_SESSION['phone'] = $tab['phone'];
            $_SESSION['mail'] = $tab['mail'];
            echo print_success('Vos infos ont bien été mises à jour !');
        } else
            echo print_error($err);
    }
}


echo '<img style="height: 100px;" class="img-thumbnail" alt="Photo de profil" src="./profilePictures/' . $_SESSION['profilePicture'] . '">';

require_once(__DIR__ . '/templates/profil.phtml');
require_once(__DIR__ . '/inc/footer.php');
