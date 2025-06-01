<?php
require_once '_db.php';

try {
    $stmt = $db->prepare("SELECT * FROM rooms ORDER BY NAME");
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    class Room {
        public $id;
        public $name;
        public $capacity;
        public $status;
    }

    $result = [];

    foreach ($rooms as $room) {
        $r = new Room();
        $r->id = $room['id'];
        $r->name = $room['NAME'];
        $r->capacity = $room['capacity'];
        $r->status = $room['STATUS'];
        $result[] = $r;
    }

    header('Content-Type: application/json');
    echo json_encode($result);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Помилка запиту: ' . $e->getMessage()]);
}
