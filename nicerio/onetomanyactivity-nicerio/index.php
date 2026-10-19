<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<?php
$cafe = getOrCreateCafe($pdo);
header('Location: viewcafe.php?cafe_id=' . (int) $cafe['cafe_id'] . '#reservation-form');
exit;
?>