<?php

function insertCafe($pdo, $cafe_name, $manager_name, $computer_type, $location) {
    $sql = "INSERT INTO cafes (cafe_name, manager_name, computer_type, location) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$cafe_name, $manager_name, $computer_type, $location]);
}

function updateCafe($pdo, $cafe_name, $manager_name, $computer_type, $location, $cafe_id) {
    $sql = "UPDATE cafes
            SET cafe_name = ?,
                manager_name = ?,
                computer_type = ?,
                location = ?
            WHERE cafe_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$cafe_name, $manager_name, $computer_type, $location, $cafe_id]);
}

function deleteCafe($pdo, $cafe_id) {
    $sql = "DELETE FROM cafes WHERE cafe_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$cafe_id]);
}

function getAllCafes($pdo) {
    $sql = "SELECT * FROM cafes ORDER BY date_added DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function getCafeByID($pdo, $cafe_id) {
    $sql = "SELECT * FROM cafes WHERE cafe_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cafe_id]);
    return $stmt->fetch();
}

function getOrCreateCafe($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM cafes WHERE cafe_name = ? LIMIT 1");
    $stmt->execute(['Anastasia Esports']);
    $cafe = $stmt->fetch();

    if ($cafe) {
        return $cafe;
    }

    $stmt = $pdo->prepare("INSERT INTO cafes (cafe_name, manager_name, computer_type, location) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Anastasia Esports', 'Cafe Manager', 'Gaming PCs', 'Location not specified']);

    return getCafeByID($pdo, $pdo->lastInsertId());
}

function insertReservation($pdo, $cafe_id, $customer_name, $contact_number, $reservation_date, $play_type, $hours_to_play, $notes = '') {
    $sql = "INSERT INTO reservations (cafe_id, customer_name, contact_number, reservation_date, play_type, hours_to_play, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$cafe_id, $customer_name, $contact_number, $reservation_date, $play_type, $hours_to_play, $notes]);
}

function getReservationsByCafe($pdo, $cafe_id) {
    $sql = "SELECT * FROM reservations WHERE cafe_id = ? ORDER BY reservation_date DESC, reservation_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$cafe_id]);
    return $stmt->fetchAll();
}

function getReservationByID($pdo, $reservation_id) {
    $sql = "SELECT * FROM reservations WHERE reservation_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$reservation_id]);
    return $stmt->fetch();
}

function updateReservation($pdo, $customer_name, $contact_number, $reservation_date, $play_type, $hours_to_play, $notes, $status, $reservation_id) {
    $sql = "UPDATE reservations
            SET customer_name = ?,
                contact_number = ?,
                reservation_date = ?,
                play_type = ?,
                hours_to_play = ?,
                notes = ?,
                status = ?
            WHERE reservation_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$customer_name, $contact_number, $reservation_date, $play_type, $hours_to_play, $notes, $status, $reservation_id]);
}

function deleteReservation($pdo, $reservation_id) {
    $sql = "DELETE FROM reservations WHERE reservation_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$reservation_id]);
}

?>