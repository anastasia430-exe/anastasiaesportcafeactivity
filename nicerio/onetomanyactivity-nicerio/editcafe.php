<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cafe</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="index.php">Return to home</a>
    <?php $cafe = getCafeByID($pdo, $_GET['cafe_id']); ?>
    <h1>Edit Cafe</h1>
    <form action="core/handleForms.php?cafe_id=<?php echo $_GET['cafe_id']; ?>" method="POST">
        <p>
            <label>Cafe Name</label>
            <input type="text" name="cafeName" value="<?php echo htmlspecialchars($cafe['cafe_name']); ?>">
        </p>
        <p>
            <label>Manager Name</label>
            <input type="text" name="managerName" value="<?php echo htmlspecialchars($cafe['manager_name']); ?>">
        </p>
        <p>
            <label>Computer Type</label>
            <input type="text" name="computerType" value="<?php echo htmlspecialchars($cafe['computer_type']); ?>">
        </p>
        <p>
            <label>Location</label>
            <input type="text" name="location" value="<?php echo htmlspecialchars($cafe['location']); ?>">
            <input type="submit" name="editCafeBtn" value="Update Cafe">
        </p>
    </form>
</body>
</html>
