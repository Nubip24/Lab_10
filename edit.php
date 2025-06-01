<?php
require_once '_db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Error: Missing or invalid reservation ID');
}

$stmt = $db->prepare("SELECT * FROM reservations WHERE id = :id");
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();

$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    die('Error: Reservation not found');
}

$rooms = $db->query("SELECT * FROM rooms");
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Edit Reservation</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h2>Редагування бронювання</h2>

    <form id="f" action="backend_update.php" method="post" style="padding:20px;">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($reservation['id']); ?>" />
        
        <div>Name:</div>
        <div><input type="text" name="name" value="<?php echo htmlspecialchars($reservation['NAME']); ?>" required /></div>
        
        <div>Start:</div>
        <div><input type="datetime-local" name="start" value="<?php 
            echo date('Y-m-d\TH:i', strtotime($reservation['START']));
        ?>" required /></div>
        
        <div>End:</div>
        <div><input type="datetime-local" name="end" value="<?php 
            echo date('Y-m-d\TH:i', strtotime($reservation['END']));
        ?>" required /></div>
        
        <div>Room:</div>
        <div>
            <select name="room" required>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['id'] ?>" <?= $room['id'] == $reservation['room_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($room['NAME']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div>Status:</div>
        <div>
            <select name="status" required>
                <?php
                    $statuses = ["New", "Confirmed", "Arrived", "CheckedOut"];
                    foreach ($statuses as $status) {
                        $selected = ($reservation['STATUS'] == $status) ? 'selected' : '';
                        echo "<option value='$status' $selected>$status</option>";
                    }
                ?>
            </select>
        </div>
        
        <div>Paid:</div>
        <div>
            <select name="paid" required>
                <?php
                    $paidOptions = [0, 50, 100];
                    foreach ($paidOptions as $option) {
                        $selected = ($reservation['paid'] == $option) ? 'selected' : '';
                        echo "<option value='$option'>{$option}%</option>";
                    }
                ?>
            </select>
        </div>
        
        <div class="space" style="margin-top:15px;">
            <input type="submit" value="Save Changes" />
            <button type="button" id="cancelBtn">Cancel</button>
        </div>
    </form>

    <script>
        function close(result) {
            if (parent && parent.DayPilot && parent.DayPilot.ModalStatic) {
                parent.DayPilot.ModalStatic.close(result);
            }
        }

        $(document).ready(function () {
            $("#f").submit(function (event) {
                event.preventDefault();
                var form = $(this);
                $.post(form.attr("action"), form.serialize(), function (result) {
                    close(result);
                }, "json").fail(function() {
                    alert("Помилка оновлення бронювання.");
                });
            });

            $("#cancelBtn").click(function () {
                close(null);
            });

            $("input[name='name']").focus();
        });
    </script>
</body>
</html>
