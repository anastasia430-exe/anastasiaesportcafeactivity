<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Cafe</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Are you sure you want to delete this cafe?</h1>
    <?php $cafe = getCafeByID($pdo, $_GET['cafe_id']); ?>
    <div class="container">
        <h2>Cafe Name: <?php echo htmlspecialchars($cafe['cafe_name']); ?></h2>
        <h2>Manager Name: <?php echo htmlspecialchars($cafe['manager_name']); ?></h2>
        <h2>Computer Type: <?php echo htmlspecialchars($cafe['computer_type']); ?></h2>
        <h2>Location: <?php echo htmlspecialchars($cafe['location']); ?></h2>
        <h2>Date Added: <?php echo htmlspecialchars($cafe['date_added']); ?></h2>

        <form action="core/handleForms.php?cafe_id=<?php echo $_GET['cafe_id']; ?>" method="POST">
            <input type="submit" name="deleteCafeBtn" value="Delete">
        </form>
    </div>
</body>
</html>
