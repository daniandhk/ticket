## Spesifikasi
PHP 8.1.6 (cli)
Database: MySQL

## Instalasi
1. Clone Repository
- Clone url berikut: https://github.com/daniandhk/ticket
- Buka terminal dan masuk ke direktori ticket yang sudah di clone

2. Konfigurasi Database
- Buat database mysql baru dengan nama "ticket"
- Buka file database.php
- Ubah konfigurasi database sesuai dengan database mysql yang sudah dibuat ($user, $password, $dbname)

3. Migrasi Database
- Pada terminal, jalankan perintah berikut: php migrate.php
- Jika berhasil, maka akan muncul pesan "Migration berhasil" pada terminal

4.  Generate Ticket
- Pada terminal, jalankan perintah berikut: php generate-ticket.php {event_id} {total_ticket}
- Contoh: php generate-ticket.php 1 100
- Jika berhasil, maka akan muncul pesan "Generate ticket berhasil" pada terminal

5. Jalankan Server untuk API
- Pada terminal, jalankan perintah berikut: php -S localhost:8000

6. Import Postman Collection
- Import file postman collection yang sudah disediakan di folder postman
- Atau akses url postman berikut: https://www.postman.com/speeding-zodiac-704472/workspace/public-dani-andhika-permana/collection/11428569-ca238ff8-36a5-44c2-9704-12fecc0934b2?action=share&creator=11428569

