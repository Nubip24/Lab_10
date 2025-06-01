<?php
require_once '_db.php';

if (!isset($_POST['NAME'], $_POST['START'], $_POST['END'], $_POST['room'])) {
    class Result {
        public string $result;
        public string $message;
    }
    $response = new Result();
    $response->result = 'ERROR';
    $response->message = 'Missing parameters';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$stmt = $db->prepare("INSERT INTO reservations (NAME, START, END, room_id, STATUS, paid) VALUES (:name, :start, :end, :room, 'New', 0)");
$stmt->bindParam(':start', $_POST['START']);
$stmt->bindParam(':end', $_POST['END']);
$stmt->bindParam(':name', $_POST['NAME']);
$stmt->bindParam(':room', $_POST['room']);
$stmt->execute();

class Result {
    public string $result;
    public string $message;
    public int $id;
}

$response = new Result();
$response->result = 'OK';
$response->message = 'Created with id: '.$db->lastInsertId();
$response->id = (int)$db->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
