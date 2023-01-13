<?php
// koneksi ke database dari database.php
require_once 'database.php';

// cek jika parameter cli tidak ada atau lebih dari 2
if (empty($argv[1]) || empty($argv[2]) || count($argv) > 3) {
    echo "- Harap jalankan file sebagai php cli dengan format: php generate-ticket.php {event_id} {total_ticket}";
    echo "\n- Harap event_id dan total_ticket diisi angka lebih dari 0";
    exit;
}

// get event_id dan total_ticket dari cli
$event_id = $argv[1];
$total_ticket = $argv[2];

// cek jika event_id dan total_ticket bukan angka
if (!is_numeric($event_id) || !is_numeric($total_ticket)) {
    echo "event_id dan total_ticket harus berupa angka";
    exit;
}

// cek jika event_id dan total_ticket kurang dari 1
if ($event_id < 1 || $total_ticket < 1) {
    echo "event_id dan total_ticket harus lebih dari 0";
    exit;
}

// get event data
$query = "SELECT * FROM events WHERE id = $event_id";
$result = $conn->query($query);
$event = $result->fetch_assoc();

// cek jika event tidak ditemukan, buat event baru
if (empty($event)) {
    $prefix = generatePrefix($conn);
    $sql = "INSERT INTO events (id, prefix) VALUES ($event_id, '$prefix')";
    $conn->query($sql);

    // get event data kembali
    $query = "SELECT * FROM events WHERE id = $event_id";
    $result = $conn->query($query);
    $event = $result->fetch_assoc();
}

// get event prefix
$prefix = $event['prefix'];

// generate ticket code
for ($i = 0; $i < $total_ticket; $i++) {
    $ticket_code = generateTicketCode($conn, $prefix);
    $sql = "INSERT INTO tickets (event_id, ticket_code) VALUES ($event_id, '$ticket_code')";
    $conn->query($sql);
}

echo "Generate ticket berhasil";

function generatePrefix($conn, $lenght = 3)
{
    $x = 0;
    $prefix = '';

    // loop sampai prefix unik ditemukan
    while (true) {
        // format prefix: huruf A-Z
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $prefix = generateRandomAlphaNumeric($lenght, $chars);
        $query = "SELECT * FROM events WHERE prefix = '$prefix'";
        $result = $conn->query($query);
        $event = $result->fetch_assoc();
        if (empty($event)) {
            break;
        }

        // handle infinite loop: 
        // dibatasi 26^$lenght loop (26 dari A-Z dan $lenght panjang prefix)
        // jika loop lebih dari 26^$lenght, tambah 1 char ke prefix dan reset loop
        $x++;
        $total_chars = strlen($chars);
        if ($x > pow($total_chars, $lenght)) {
            $lenght++;
            $x = 0;
        }
    }

    return $prefix;
}

function generateTicketCode($conn, $prefix, $lenght = 7)
{
    $x = 0;
    $ticket_code = '';

    // loop sampai ticket_code unik ditemukan
    while (true) {
        // format random alphanumeric: huruf A-Z dan 0-9
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random_alphanumeric = generateRandomAlphaNumeric($lenght, $chars);

        // format ticket_code: {prefix}{random alphanumeric}
        $ticket_code = $prefix . $random_alphanumeric;

        // cek jika ticket_code sudah ada di database
        $query = "SELECT * FROM tickets WHERE ticket_code = '$ticket_code'";
        $result = $conn->query($query);
        $ticket = $result->fetch_assoc();
        if (empty($ticket)) {
            break;
        }

        // handle infinite loop: 
        // dibatasi 36^$lenght loop (36 dari A-Z dan 0-9 dan $lenght panjang random alphanumeric)
        // jika loop lebih dari 36^$lenght, tambah 1 char ke random alphanumeric dan reset loop
        $x++;
        $total_chars = strlen($chars);
        if ($x > pow($total_chars, $lenght)) {
            $lenght++;
            $x = 0;
        }
    }

    return $ticket_code;
}

function generateRandomAlphaNumeric($length = 10, $characters)
{
    $charactersLength = strlen($characters);
    $randomString = '';

    // loop sebanyak $length
    for ($i = 0; $i < $length; $i++) {
        // randomize index dari $characters
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
