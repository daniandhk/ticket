<?php
// koneksi ke database dari database.php
require_once 'database.php';

// create table events
$query = "CREATE TABLE IF NOT EXISTS events (
    id INT PRIMARY KEY AUTO_INCREMENT,
    prefix VARCHAR(10) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
$conn->query($query);

// create table tickets dengan foreign key ke table events
$query = "CREATE TABLE IF NOT EXISTS tickets (
    id SERIAL PRIMARY KEY,
    event_id INT NOT NULL,
    ticket_code VARCHAR(20) NOT NULL,
    status VARCHAR(10) NOT NULL DEFAULT 'available',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id)
)";
$conn->query($query);

// cek jika table events kosong
$query = "SELECT * FROM events";
$result = $conn->query($query);
$events = $result->fetch_all(MYSQLI_ASSOC);

// jika table events kosong, insert data dummy
if (empty($events)) {
    $query = "INSERT INTO events (prefix) VALUES ('ABC')";
    $conn->query($query);
}

// cek jika table tickets kosong
$query = "SELECT * FROM tickets";
$result = $conn->query($query);
$tickets = $result->fetch_all(MYSQLI_ASSOC);

// jika table tickets kosong, insert data dummy
if (empty($tickets)) {
    $query = "INSERT INTO tickets (event_id, ticket_code) VALUES (1, 'ABC01AHB89')";
    $conn->query($query);
}

echo 'Migration berhasil';
