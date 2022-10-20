<?php
if(!file_exists('config.php'))
{
    echo "Add a 'config.php' file at the root and return your PDO config.";
    die;
}
require_once('config.php');

function dbconnect()
{
    $param = getParameters();
    return (new PDO(
        $param['db_dsn'],
        $param['db_pseudo'],
        $param['db_pwd']
    ));
}

function getMember($id)
{
    $pdo = dbconnect();
    $qr = $pdo->prepare('SELECT * FROM members WHERE id = ?');
    $qr->execute([$id]);

    return $qr->fetch(PDO::FETCH_ASSOC);
}

function updateMember($str)
{
    $pdo = dbconnect();
    $qr = $pdo->prepare($str);
    $qr->execute();
}

function getConvos()
{
    $pdo = dbconnect();
    $qr = $pdo->prepare('SELECT * FROM conversations WHERE memberId1 = ? OR memberId2 = ?');
    $qr->execute([$_SESSION['id'], $_SESSION['id']]);

    return $qr->fetchAll(PDO::FETCH_ASSOC);
}

function getMsgs($id)
{
    $pdo = dbconnect();
    $qr = $pdo->prepare("SELECT convoId, msgFrom, content, DATE_FORMAT(time, '%d/%m/%Y') AS time_day, DATE_FORMAT(time, '%Hh%i') AS time_hour FROM messages WHERE convoId = ?");
    $qr->execute([$id]);

    return $qr->fetchAll(PDO::FETCH_ASSOC);
}

function getConvo($id)
{
    $pdo = dbconnect();
    $qr = $pdo->prepare('SELECT * FROM conversations WHERE (memberId1 = ? AND memberId2 = ?) OR (memberId1 = ? AND memberId2 = ?) ');
    $qr->execute([$_SESSION['id'], $id, $id, $_SESSION['id']]);

    return $qr->fetch(PDO::FETCH_ASSOC);
}

function createAndGetConvo($id)
{
    $pdo = dbconnect();
    $qr = $pdo->prepare('INSERT INTO conversations (id, memberId1, memberId2) VALUES (NULL, ?, ?)');
    $qr->execute([$_SESSION['id'], $id]);
    $qr = $pdo->prepare('SELECT * FROM conversations WHERE memberId1 = ? AND memberId2 = ?');
    $qr->execute([$_SESSION['id'], $id]);

    return $qr->fetch(PDO::FETCH_ASSOC);
}

function sendMsg($convoId, $msg)
{
    $pdo = dbconnect();
    $qr = $pdo->prepare('INSERT INTO messages (id, convoId, msgFrom, content, time) VALUES (NULL, ?, ?, ?, now())');
    $qr->execute([$convoId, $_SESSION['id'], $msg]);
    header('refresh:0');
}

function display_msg($msg)
{
    $member = getMember($msg['msgFrom']);
    if ($_SESSION['id'] == $msg['msgFrom'])
        $divClass = 'text-end';
    else
        $divClass = 'text-start';
    echo '<div class="me-2 ms-2 ' . $divClass . '">';
    echo 'De <b>' . $member['firstName'] . ' ' . $member['lastName'] . '</b><br>' . $msg['content'] . '<br><small class="form-text">Envoyé le ' . $msg['time_day'] . ' à ' . $msg['time_hour'] . '</small><br>';
    echo '</div>';
    echo '<hr>';
}

function display_conv($conv)
{
    if ($conv['memberId1'] == $_SESSION['id'])
        $other = $conv['memberId2'];
    else
        $other = $conv['memberId1'];

    $member = getMember($other);
    if (isset($_GET['id']) && $_GET['id'] == $other) {
        echo '<tr class="table-active">';
        $loc = "location.href='#'";
    } else {
        echo '<tr>';
        $loc = "location.href='./msgs.php?id=" . $other . "'";
    }
    echo '<td onclick="' . $loc . '" style="cursor: pointer;">Conversation avec ' . $member['firstName'] . ' ' . $member['lastName'] . '</td></tr>';
}
