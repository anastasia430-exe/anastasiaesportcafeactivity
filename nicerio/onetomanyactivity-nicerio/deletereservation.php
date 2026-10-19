<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Reservation</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Are you sure you want to delete this play reservation?</h1>
    <?php $reservation = getReservationByID($pdo, $_GET['reservation_id']); ?>
    <div class="container">
        <h2>Customer: <?php echo htmlspecialchars($reservation['customer_name']); ?></h2>
        <h2>Contact: <?php echo htmlspecialchars($reservation['contact_number']); ?></h2>
        <h2>Date: <?php echo htmlspecialchars($reservation['reservation_date']); ?></h2>
        <h2>Play Type: <?php echo htmlspecialchars($reservation['play_type'] ?? 'Normal'); ?></h2>
        <h2>Hours to Play: <?php echo htmlspecialchars($reservation['hours_to_play']); ?></h2>
        <h2>Status: <?php echo htmlspecialchars($reservation['status']); ?></h2>

        <form action="core/handleForms.php?reservation_id=<?php echo $_GET['reservation_id']; ?>&cafe_id=<?php echo $_GET['cafe_id']; ?>" method="POST">
            <input type="submit" name="deleteReservationBtn" value="Delete">
        </form>
    </div>
</body>
</html>
