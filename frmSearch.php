<?php
require_once(__DIR__ . '/db_func.php');

$pdo = dbconnect();
if (!empty($_POST["keyword"])) {
    $qr = $pdo->prepare("SELECT name FROM cities WHERE name like ? ORDER BY name LIMIT 0,6");
    $qr->execute([$_POST['keyword'] . '%']);
    $tab = $qr->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($tab)) {
        foreach ($tab as $city) {
?><div onClick="selectCity('<?= $city["name"] ?>');"><?= $city["name"] ?></div>
<?php
        }
    }
}
?>