<?php
require_once(__DIR__ . '/inc/header.php');

$err = '';

if (!empty($_SESSION))
    header('Location: profil.php');

if (!empty($_POST)) {
    if (
        empty($_POST['mail']) ||
        empty($_POST['pwd']) ||
        empty($_POST['firstName']) ||
        empty($_POST['lastName']) ||
        empty($_POST['phone'])
    )
        $err .= 'Veuillez remplir tous les champs.<br>';

    $mail = htmlentities(trim($_POST['mail']));
    $sfn = htmlentities(trim($_POST['firstName']));
    $sln = htmlentities(trim($_POST['lastName']));
    $pwd = htmlentities(trim($_POST['pwd']));
    $phone = $_POST['phone'];

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        $err .= 'Veuillez utiliser une adresse mail correcte.<br>';


    if (preg_match('/^[0-9]{10}+$/', $phone) !== 1)
        $err .= 'Erreur dans le numéro de téléphone.<br>';

    $pdo = dbconnect();
    $qr = $pdo->query('SELECT name FROM cities WHERE name LIKE "' . $_POST['city'] . '"');
    $tab = $qr->fetch(PDO::FETCH_ASSOC);
    if (empty($tab))
        $err .= 'Cette ville n\'existe pas.<br>';
        
    $qr = $pdo->prepare('SELECT mail FROM members WHERE mail = ? AND role = ?');
    $qr->execute([$mail, $_POST['role']]);
    $arr = $qr->fetch(PDO::FETCH_ASSOC);

    if (!empty($arr))
        $err .= 'Cette adresse mail existe déjà.<br>';

    if ($_FILES['profilePicture']['type'] != 'image/jpeg')
        $err .= 'L\'image doit être au format jpg ou jpeg.<br>';

    if (empty($err)) {
        $file_name = uniqid(rand()) . $mail . '.jpg';
        if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], __DIR__ . '/img/' . $file_name)) {
            $qr = $pdo->prepare('INSERT INTO members VALUES (NULL, ?, ?, curdate(), ?, ?, ?, ?, ?, NULL, ?)');
            $qr->execute(array($mail, base64_encode($pwd), $sfn, $sln, $_POST['city'], $phone, $file_name, $_POST['role']));
            echo print_success('Inscription terminée ! Vous pouvez à présent vous connecter.');
        } else
            echo print_error('Error during file upload : please contact an admin<br>');
    } else
        echo print_error($err);
}
require_once(__DIR__ . '/templates/inscription.html');
require_once(__DIR__ . '/inc/footer.php');
