<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "internet_cafe";
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    $pdo->exec("SET time_zone = '+08:00';");

    $tableExists = function ($tableName) use ($pdo) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?");
        $stmt->execute([$tableName]);
        return (int) $stmt->fetchColumn() > 0;
    };
    $columnExists = function ($tableName, $columnName) use ($pdo) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?");
        $stmt->execute([$tableName, $columnName]);
        return (int) $stmt->fetchColumn() > 0;
    };

    if ($tableExists('restaurants') && !$tableExists('cafes')) {
        $foreignKeys = $pdo->query("SELECT DISTINCT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'reservations' AND REFERENCED_TABLE_NAME = 'restaurants'")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($foreignKeys as $foreignKey) {
            $pdo->exec('ALTER TABLE reservations DROP FOREIGN KEY `' . str_replace('`', '``', $foreignKey) . '`');
        }

        $pdo->exec("RENAME TABLE restaurants TO cafes");
    }

    if ($tableExists('cafes')) {
        $cafeColumns = [
            'restaurant_id' => 'cafe_id INT NOT NULL AUTO_INCREMENT',
            'restaurant_name' => 'cafe_name VARCHAR(100) NOT NULL',
            'owner_name' => 'manager_name VARCHAR(100) NOT NULL',
            'cuisine' => 'computer_type VARCHAR(80) NOT NULL'
        ];
        foreach ($cafeColumns as $oldName => $newDefinition) {
            $newName = strtok($newDefinition, ' ');
            if ($columnExists('cafes', $oldName) && !$columnExists('cafes', $newName)) {
                $pdo->exec('ALTER TABLE cafes CHANGE COLUMN `' . $oldName . '` ' . $newDefinition);
            }
        }
    }

    if ($tableExists('reservations')) {
        if ($columnExists('reservations', 'restaurant_id') && !$columnExists('reservations', 'cafe_id')) {
            $pdo->exec("ALTER TABLE reservations CHANGE COLUMN restaurant_id cafe_id INT NOT NULL");
        }
        if ($columnExists('reservations', 'reservation_time')) {
            $pdo->exec("ALTER TABLE reservations MODIFY COLUMN reservation_time TIME NULL DEFAULT NULL");
        }
        if (!$columnExists('reservations', 'play_type')) {
            $pdo->exec("ALTER TABLE reservations ADD play_type ENUM('Normal', 'VIP', 'VVIP') NOT NULL DEFAULT 'Normal' AFTER reservation_date");
        }

        $cafeForeignKey = $pdo->prepare("SELECT COUNT(*) FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'reservations' AND COLUMN_NAME = 'cafe_id' AND REFERENCED_TABLE_NAME = 'cafes'");
        $cafeForeignKey->execute();
        if ((int) $cafeForeignKey->fetchColumn() === 0 && $tableExists('cafes') && $columnExists('reservations', 'cafe_id')) {
            $pdo->exec("ALTER TABLE reservations ADD CONSTRAINT fk_reservations_cafes FOREIGN KEY (cafe_id) REFERENCES cafes(cafe_id) ON DELETE CASCADE");
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>