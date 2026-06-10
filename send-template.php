<?php
/**
 * ============================================================
 * Kirim WhatsApp Template Message - Whatscrm Official API
 * Template  : account_activity_notice
 * Endpoint  : POST /api/v1/send-template
 * Docs      : https://whatscrm.id
 * ============================================================
 *
 * Cara pakai:
 * 1. Ganti YOUR_API_KEY dengan API Key kamu
 * 2. Ganti phone_number dengan nomor tujuan (format internasional)
 * 3. Jalankan: php send-template.php
 */

// -------------------------------------------------------
// Konfigurasi API
// -------------------------------------------------------
$apiKey   = 'YOUR_API_KEY';                              // Ganti dengan API Key kamu
$endpoint = 'https://whatscrm.id/api/v1/send-template'; // URL endpoint

// -------------------------------------------------------
// Payload / Body Request
// -------------------------------------------------------
$payload = [
    'phone_number'  => '628123456789',           // Nomor WhatsApp tujuan (tanpa + di depan)
    'to_name'       => 'John Doe',               // Nama penerima pesan
    'name_template' => 'account_activity_notice',// Nama template yang sudah disetujui Meta
    'language_code' => 'en',                     // Kode bahasa template (en = English)

    // Parameter yang akan mengisi variabel di dalam template
    // Urutan array sesuai urutan variabel pada template
    'body_params'   => [
        '{{2}}', // Nilai untuk variabel pertama di template
        '{{1}}', // Nilai untuk variabel kedua di template
    ],
];

// -------------------------------------------------------
// Inisialisasi cURL
// -------------------------------------------------------
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL            => $endpoint,           // URL tujuan request
    CURLOPT_POST           => true,                // Method: POST
    CURLOPT_RETURNTRANSFER => true,                // Kembalikan response sebagai string
    CURLOPT_POSTFIELDS     => json_encode($payload),// Encode payload ke JSON
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',          // Beritahu server kita kirim JSON
        'Accept: application/json',                // Minta server balas dengan JSON
        'X-API-KEY: Bearer ' . $apiKey,            // Autentikasi menggunakan API Key
    ],
]);

// -------------------------------------------------------
// Eksekusi Request
// -------------------------------------------------------
$response = curl_exec($ch);

// Ambil HTTP status code dari response
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Tutup koneksi cURL setelah selesai
curl_close($ch);

// -------------------------------------------------------
// Proses Response
// -------------------------------------------------------

// Decode JSON response menjadi PHP array
$result = json_decode($response, true);

// Cek apakah request berhasil
if ($httpCode === 200 && ($result['status'] ?? '') === 'success') {
    echo "Success! Message ID: " . $result['message_id'];
} else {
    echo "Failed: " . ($result['message'] ?? 'Unknown error');
}
