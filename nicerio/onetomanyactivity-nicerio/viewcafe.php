<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<?php
$cafeID = isset($_GET['cafe_id']) ? (int) $_GET['cafe_id'] : 0;
$cafe = $cafeID > 0 ? getCafeByID($pdo, $cafeID) : null;
if (!$cafe) {
    $cafe = getOrCreateCafe($pdo);
    $cafeID = (int) $cafe['cafe_id'];
}
$reservations = getReservationsByCafe($pdo, $cafeID);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internet Cafe Reservations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="reservation-page">

    <?php if ($cafe): ?>
        <h1><?php echo htmlspecialchars($cafe['cafe_name']); ?></h1>
        <p><strong>Manager:</strong> <?php echo htmlspecialchars($cafe['manager_name']); ?></p>
        <p><strong>Computer Type:</strong> <?php echo htmlspecialchars($cafe['computer_type']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($cafe['location']); ?></p>
        <p><strong>Date Added:</strong> <?php echo htmlspecialchars($cafe['date_added']); ?></p>
    <?php else: ?>
        <h1>ANASTASIA Esports</h1>
    <?php endif; ?>

    <h2>Reserve a Computer / Play Time</h2>
    <?php if (isset($_GET['saved'])): ?>
        <p>Reservation saved successfully.</p>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'invalid_date'): ?>
        <p>Please choose a valid reservation date that is today or later.</p>
    <?php endif; ?>
    <form id="reservation-form" action="core/handleForms.php?cafe_id=<?php echo $cafeID; ?>" method="POST">
        <p>
            <label>Customer Name</label>
            <input type="text" name="customerName" required>
        </p>
        <p>
            <label>Contact Number</label>
            <input type="text" name="contactNumber" required>
        </p>
        <p>
            <label>Reservation Date</label>
            <input type="date" name="reservationDate" min="<?php echo date('Y-m-d'); ?>" required>
        </p>
        <p>
            <label>Play Type</label>
            <select name="playType" required>
                <option value="Normal">Normal</option>
                <option value="VIP">VIP</option>
                <option value="VVIP">VVIP</option>
            </select>
        </p>
        <p>
            <label>How many hours to play</label>
            <select name="hoursToPlay" required>
                <option value="1">1 Hour</option>
                <option value="2">2 Hours</option>
                <option value="3">3 Hours</option>
                <option value="4">4 Hours</option>
                <option value="5">5 Hours</option>
                <option value="6">6 Hours</option>
                <option value="7">7 Hours</option>
                <option value="8">8 Hours</option>
            </select>
        </p>
        <p>
            <label>Notes</label>
            <input type="text" name="notes">
            <input type="submit" name="insertReservationBtn" value="Reserve Play">
        </p>
    </form>

    <h2>Reservations</h2>
    <table>
        <tr>
            <th>Reservation ID</th>
            <th>Customer</th>
            <th>Contact</th>
            <th>Date</th>
            <th>Play Type</th>
            <th>Hours</th>
            <th>Status</th>
            <th>Notes</th>
            <th>Action</th>
        </tr>
        <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?php echo $reservation['reservation_id']; ?></td>
                <td><?php echo htmlspecialchars($reservation['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($reservation['contact_number']); ?></td>
                <td><?php echo htmlspecialchars($reservation['reservation_date']); ?></td>
                <td><?php echo htmlspecialchars($reservation['play_type'] ?? 'Normal'); ?></td>
                <td><?php echo htmlspecialchars($reservation['hours_to_play'] ?? '1'); ?> hour(s)</td>
                <td><?php echo htmlspecialchars($reservation['status'] ?? 'Pending'); ?></td>
                <td><?php echo htmlspecialchars($reservation['notes'] ?? ''); ?></td>
                <td>
                    <a href="editreservation.php?reservation_id=<?php echo $reservation['reservation_id']; ?>&cafe_id=<?php echo $cafeID; ?>">Edit</a>
                    <a href="deletereservation.php?reservation_id=<?php echo $reservation['reservation_id']; ?>&cafe_id=<?php echo $cafeID; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
