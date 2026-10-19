<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Reservation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="viewcafe.php?cafe_id=<?php echo $_GET['cafe_id']; ?>">Back to reservations</a>
    <?php $reservation = getReservationByID($pdo, $_GET['reservation_id']); ?>
    <h1>Edit Reservation</h1>
    <form action="core/handleForms.php?reservation_id=<?php echo $_GET['reservation_id']; ?>&cafe_id=<?php echo $_GET['cafe_id']; ?>" method="POST">
        <p>
            <label>Customer Name</label>
            <input type="text" name="customerName" value="<?php echo htmlspecialchars($reservation['customer_name']); ?>" required>
        </p>
        <p>
            <label>Contact Number</label>
            <input type="text" name="contactNumber" value="<?php echo htmlspecialchars($reservation['contact_number']); ?>" required>
        </p>
        <p>
            <label>Reservation Date</label>
            <input type="date" name="reservationDate" min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($reservation['reservation_date']); ?>" required>
        </p>
        <p>
            <label>Play Type</label>
            <select name="playType" required>
                <option value="Normal" <?php echo (($reservation['play_type'] ?? 'Normal') === 'Normal') ? 'selected' : ''; ?>>Normal</option>
                <option value="VIP" <?php echo (($reservation['play_type'] ?? '') === 'VIP') ? 'selected' : ''; ?>>VIP</option>
                <option value="VVIP" <?php echo (($reservation['play_type'] ?? '') === 'VVIP') ? 'selected' : ''; ?>>VVIP</option>
            </select>
        </p>
        <p>
            <label>How many hours to play</label>
            <select name="hoursToPlay" required>
                <?php for ($i = 1; $i <= 8; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($reservation['hours_to_play'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?> Hour(s)</option>
                <?php endfor; ?>
            </select>
        </p>
        <p>
            <label>Status</label>
            <select name="status">
                <option value="Pending" <?php echo ($reservation['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Confirmed" <?php echo ($reservation['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="Cancelled" <?php echo ($reservation['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </p>
        <p>
            <label>Notes</label>
            <input type="text" name="notes" value="<?php echo htmlspecialchars($reservation['notes'] ?? ''); ?>">
            <input type="submit" name="editReservationBtn" value="Update Reservation">
        </p>
    </form>
</body>
</html>
