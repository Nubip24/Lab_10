<?php
require_once '_db.php';

if (!isset($_POST['start']) || !isset($_POST['end'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Відсутні параметри start або end']);
    exit;
}

$start_date = $_POST['start'];
$end_date = $_POST['end'];

$start = $start_date . ' 00:00:00';
$end = $end_date . ' 23:59:59';

try {
    $stmt = $db->prepare("SELECT * FROM reservations WHERE NOT ((`END` <= :start) OR (`START` >= :end))");
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $events = [];

    foreach ($result as $row) {
        $events[] = [
            'id' => $row['id'],
            'text' => $row['NAME'],
            'start' => $row['START'],
            'end' => $row['END'],
            'resource' => $row['room_id'],
            'bubbleHtml' => "Reservation details: " . $row['NAME'],
            'status' => $row['STATUS'],
            'paid' => $row['paid'],
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($events);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Помилка запиту: ' . $e->getMessage()]);
}
