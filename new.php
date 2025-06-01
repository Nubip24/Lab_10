<?php
require_once '_db.php';

$rooms = $db->query('SELECT * FROM rooms');

$start = isset($_GET['start']) ? $_GET['start'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';

if ($start) {
    $start = date('Y-m-d H:i:s', strtotime($start));
}
if ($end) {
    $end = date('Y-m-d H:i:s', strtotime($end));
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Нове бронювання</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="f" action="backend_create.php" method="post" style="padding:20px;">
        <h1>Нове бронювання</h1>

        <label>Ім'я бронювання:<br>
            <input type="text" id="name" name="NAME" required />
        </label><br><br>

        <label>Початок:<br>
            <input type="datetime-local" id="start" name="START" 
                value="<?php echo htmlspecialchars(str_replace(' ', 'T', $start)); ?>" required />
        </label><br><br>

        <label>Кінець:<br>
            <input type="datetime-local" id="end" name="END" 
                value="<?php echo htmlspecialchars(str_replace(' ', 'T', $end)); ?>" required />
        </label><br><br>

        <label>Кімната:<br>
            <select id="room" name="room">
                <?php 
                    foreach ($rooms as $room) {
                        $selected = (isset($_GET['resource']) && $_GET['resource'] == $room['id']) ? ' selected' : '';
                        $id = htmlspecialchars($room['id']);
                        $name = htmlspecialchars($room['NAME']);
                        echo "<option value='$id'$selected>$name</option>";
                    }
                ?>
            </select>
        </label><br><br>

        <input type="submit" value="Зберегти" />
        <button type="button" onclick="closeModal()">Відмінити</button>
    </form>

    <script>
        function closeModal(result) {
            if (window.parent && window.parent.DayPilot && window.parent.DayPilot.ModalStatic) {
                window.parent.DayPilot.ModalStatic.close(result);
            }
        }

        $(function() {
            $("#f").submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.post(form.attr("action"), form.serialize(), function(response) {
                    if (response.result === "OK") {
                        closeModal(response);
                    } else {
                        alert("Помилка: " + (response.message || "невідома"));
                    }
                }, "json").fail(function() {
                    alert("Помилка при зверненні до сервера.");
                });
            });

            $("#name").focus();
        });
    </script>
</body>
</html>
