<?php

require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['insertCafeBtn'])) {
    $query = insertCafe(
        $pdo,
        $_POST['cafeName'],
        $_POST['managerName'],
        $_POST['computerType'],
        $_POST['location']
    );

    if ($query) {
        header('Location: ../index.php');
        exit;
    }

    echo 'Insertion failed';
}

if (isset($_POST['editCafeBtn'])) {
    $query = updateCafe(
        $pdo,
        $_POST['cafeName'],
        $_POST['managerName'],
        $_POST['computerType'],
        $_POST['location'],
        $_GET['cafe_id']
    );

    if ($query) {
        header('Location: ../index.php');
        exit;
    }

    echo 'Edit failed';
}

if (isset($_POST['deleteCafeBtn'])) {
    $query = deleteCafe($pdo, $_GET['cafe_id']);

    if ($query) {
        header('Location: ../index.php');
        exit;
    }

    echo 'Deletion failed';
}

if (isset($_POST['insertReservationBtn'])) {
    $cafeID = isset($_GET['cafe_id']) ? (int) $_GET['cafe_id'] : 0;
    $cafe = $cafeID > 0 ? getCafeByID($pdo, $cafeID) : null;
    if (!$cafe) {
        $cafe = getOrCreateCafe($pdo);
        $cafeID = (int) $cafe['cafe_id'];
    }

    $reservationDate = $_POST['reservationDate'] ?? '';
    $dateValue = DateTimeImmutable::createFromFormat('!Y-m-d', $reservationDate);
    if (!$dateValue || $dateValue->format('Y-m-d') !== $reservationDate || $dateValue < new DateTimeImmutable('today')) {
        header('Location: ../viewcafe.php?cafe_id=' . $cafeID . '&error=invalid_date#reservation-form');
        exit;
    }

    $query = insertReservation(
        $pdo,
        $cafeID,
        $_POST['customerName'],
        $_POST['contactNumber'],
        $reservationDate,
        $_POST['playType'],
        $_POST['hoursToPlay'],
        $_POST['notes']
    );

    if ($query) {
        header('Location: ../viewcafe.php?cafe_id=' . $cafeID . '&saved=1');
        exit;
    }

    echo 'Reservation failed';
}

if (isset($_POST['editReservationBtn'])) {
    $query = updateReservation(
        $pdo,
        $_POST['customerName'],
        $_POST['contactNumber'],
        $_POST['reservationDate'],
        $_POST['playType'],
        $_POST['hoursToPlay'],
        $_POST['notes'],
        $_POST['status'],
        $_GET['reservation_id']
    );

    if ($query) {
        header('Location: ../viewcafe.php?cafe_id=' . $_GET['cafe_id']);
        exit;
    }

    echo 'Reservation update failed';
}

if (isset($_POST['deleteReservationBtn'])) {
    $query = deleteReservation($pdo, $_GET['reservation_id']);

    if ($query) {
        header('Location: ../viewcafe.php?cafe_id=' . $_GET['cafe_id']);
        exit;
    }

    echo 'Reservation deletion failed';
}

?>