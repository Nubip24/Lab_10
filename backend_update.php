<?php
require_once '_db.php';

// Перевірка обов’язкових параметрів
if (
    !isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['start']) ||
    !isset($_POST['end']) || !isset($_POST['room']) || !isset($_POST['status']) || !isset($_POST['paid'])
) {
    $response = [
        'result' => 'ERROR',
        'message' => 'Missing parameters'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Підготовка SQL-запиту
$stmt = $db->prepare("
    UPDATE reservations 
    SET NAME = :name, START = :start, END = :end, room_id = :room, STATUS = :status, paid = :paid 
    WHERE id = :id
");

$stmt->bindParam(':id', $_POST['id']);
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':start', $_POST['start']);
$stmt->bindParam(':end', $_POST['end']);
$stmt->bindParam(':room', $_POST['room']);
$stmt->bindParam(':status', $_POST['status']);
$stmt->bindParam(':paid', $_POST['paid']);
$stmt->execute();

// Відповідь у форматі JSON
$response = [
    'result' => 'OK',
    'message' => 'Update successful'
];

header('Content-Type: application/json');
echo json_encode($response);
