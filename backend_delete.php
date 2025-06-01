<?php
require_once '_db.php';

class Result {
    public string $result;
    public string $message;
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    $response = new Result();
    $response->result = 'ERROR';
    $response->message = 'Missing or invalid reservation ID';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

$id = (int)$_POST['id'];

$stmt = $db->prepare("DELETE FROM reservations WHERE ID = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    $response = new Result();
    $response->result = 'OK';
    $response->message = "Reservation with ID $id deleted successfully.";
} else {
    $response = new Result();
    $response->result = 'ERROR';
    $response->message = 'Failed to delete reservation.';
}

header('Content-Type: application/json');
echo json_encode($response);
