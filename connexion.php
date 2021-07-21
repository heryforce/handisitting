<?php
require_once(__DIR__ . '/inc/header.php');

if (!empty($_SESSION))
    header('Location: profil.php');

if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
    $pdo = dbconnect();
    $qr = $pdo->prepare('SELECT * FROM members WHERE mail = ? AND pwd = ? AND role = ?');
    $qr->execute(array(htmlentities($_POST['email']), base64_encode(htmlentities($_POST['password'])), $_POST['role']));
    //var_dump($qr);
    $arr = $qr->fetch(PDO::FETCH_ASSOC);
    //var_dump($arr);

    if (empty($arr)) {
        echo print_error("Adresse mail ou mot de passe incorrect.");
    } else {
        $_SESSION['id'] = $arr['id'];
        $_SESSION['mail'] = $arr['mail'];
        $_SESSION['firstName'] = $arr['firstName'];
        $_SESSION['lastName'] = $arr['lastName'];
        $_SESSION['city'] = $arr['city'];
        $_SESSION['phone'] = $arr['phone'];
        $_SESSION['profilePicture'] = $arr['profilePicture'];
        $_SESSION['registerDate'] = $arr['registerDate'];
        $_SESSION['bio'] = $arr['bio'];
        $_SESSION['role'] = $arr['role'];
        header('Location: profil.php');
    }
}
require_once(__DIR__ . '/templates/connexion.html');
require_once(__DIR__ . '/inc/footer.php');
?>