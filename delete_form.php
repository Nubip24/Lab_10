<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Delete Reservation</title>
</head>
<body>
    <h2>Delete a reservation</h2>
    <form action="backend_delete.php" method="post">
        <label for="id">Enter the booking ID to delete:</label><br />
        <input type="number" name="id" id="id" required min="1" /><br /><br />
        <input type="submit" value="Delete" />
    </form>
</body>
</html>
