<?php
// koneksi ke database dari database.php
require_once 'database.php';

// cek jika params kosong, return error
if (empty($_GET['event_id']) || empty($_GET['ticket_code'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'params tidak boleh kosong'
    ]);
    exit;
}

// get event id dan ticket code dari params
$event_id = $_GET['event_id'];
$ticket_code = $_GET['ticket_code'];

// cek jika ticket code ada
$query = "SELECT * FROM tickets WHERE event_id = '$event_id' AND ticket_code = '$ticket_code'";
$result = $conn->query($query);
$ticket = $result->fetch_assoc();

// jika ticket code tidak ditemukan, return error
if (empty($ticket)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ticket_code tidak ditemukan'
    ]);
    exit;
}

// format response: ticket_code dan status
echo json_encode([
    'ticket_code' => $ticket['ticket_code'],
    'status' => $ticket['status']
]);
exit;
