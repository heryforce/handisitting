<?php
require_once(__DIR__ . '/inc/header.php');

if(empty($_GET))
    header('Location: index.php');

if(empty($res = getMember($_GET['id'])))
    header('Location: index.php');

if(isset($_SESSION['id']) && $_GET['id'] === $_SESSION['id'])
    header('location: profil.php');

require_once(__DIR__ . '/templates/member.phtml');
require_once(__DIR__ . '/inc/footer.php');