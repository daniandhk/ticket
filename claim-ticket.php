<?php
// koneksi ke database dari database.php
require_once 'database.php';

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

// jika ticket code sudah di claim, return error
if ($ticket['status'] == 'claimed') {
    echo json_encode([
        'status' => 'error',
        'message' => 'ticket_code sudah di claim'
    ]);
    exit;
}

// update ticket status menjadi claimed
$query = "UPDATE tickets SET status = 'claimed' WHERE ticket_code = '$ticket_code'";
$conn->query($query);

// cek kembali ticket status
$query = "SELECT * FROM tickets WHERE ticket_code = '$ticket_code'";
$result = $conn->query($query);
$ticket = $result->fetch_assoc();

// format response: ticket_code, status, dan updated_at
if ($ticket['status'] == 'claimed') {
    echo json_encode([
        'ticket_code' => $ticket['ticket_code'],
        'status' => $ticket['status'],
        'updated_at' => $ticket['updated_at']
    ]);
    exit;
}

// jika ticket code tidak bisa di claim, return error
echo json_encode([
    'status' => 'error',
    'message' => 'ticket_code tidak bisa di claim'
]);
exit;
