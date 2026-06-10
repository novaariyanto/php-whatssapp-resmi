# Send WhatsApp Template Message Using PHP

Simple example sending **WhatsApp Template Message** using [Whatscrm](https://whatscrm.id) Official API with **Native PHP** and **cURL** — no framework, no composer, no third-party package required.

> Cocok untuk developer PHP pemula yang ingin integrasi **WhatsApp API** dengan cepat.

---

## Features

- Native PHP — tanpa framework
- No Composer — tanpa dependency manager
- Simple cURL — hanya 1 file PHP
- WhatsApp Business API (Official Meta Partner)
- Copy Paste Ready — langsung bisa dipakai

---

## Requirements

- PHP 7.4 atau lebih baru
- Ekstensi cURL aktif (`extension=curl` di `php.ini`)
- API Key Whatscrm

---

## Getting API Key

Sebelum menggunakan contoh ini, kamu perlu memiliki **API Key Whatscrm**.

**Langkah mendapatkan API Key:**

1. Daftar akun di [https://whatscrm.id](https://whatscrm.id)
2. Hubungi Admin untuk aktivasi fitur API
3. Dapatkan API Key dari menu **Developer > API Keys**

**Hubungi Admin:**

[![WhatsApp](https://img.shields.io/badge/WhatsApp-0895361034833-25D366?logo=whatsapp)](https://wa.me/62895361034833)

---

## Example

```php
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
```

---

## Request Parameters

| Parameter       | Type     | Required | Description                                                  |
|----------------|----------|----------|--------------------------------------------------------------|
| `phone_number`  | `string` | Yes      | Nomor WhatsApp tujuan dalam format internasional, tanpa `+` (contoh: `628123456789`) |
| `to_name`       | `string` | Yes      | Nama penerima pesan yang akan ditampilkan di template        |
| `name_template` | `string` | Yes      | Nama template WhatsApp yang sudah disetujui oleh Meta        |
| `language_code` | `string` | Yes      | Kode bahasa template (contoh: `en`, `id`)                   |
| `body_params`   | `array`  | No       | Array nilai untuk mengisi variabel `{{1}}`, `{{2}}`, dst di dalam body template |

---

## Success Response

HTTP Status: `200 OK`

```json
{
    "status": "success",
    "message": "Message sent successfully",
    "message_id": "wamid.HBgLNjI4MTIzNDU2Nzg5FQIAERgSM0I2RjBBQTI1RDRCMTM5NDQAA"
}
```

---

## Error Response

HTTP Status: `401 Unauthorized` / `422 Unprocessable Entity` / `500 Internal Server Error`

```json
{
    "status": "error",
    "message": "Invalid API Key"
}
```

```json
{
    "status": "error",
    "message": "phone_number is required"
}
```

---

## Use Cases

Contoh penggunaan nyata **WhatsApp API PHP** dengan template message:

| Use Case                   | Deskripsi                                              |
|---------------------------|--------------------------------------------------------|
| **WhatsApp OTP**           | Kirim kode OTP verifikasi ke nomor pengguna            |
| **WhatsApp Notification**  | Kirim notifikasi otomatis (pesanan, pembayaran, dll)   |
| **WhatsApp Invoice**       | Kirim invoice atau struk transaksi ke pelanggan        |
| **WhatsApp Verification**  | Verifikasi nomor HP saat registrasi akun               |
| **WhatsApp Reminder**      | Kirim pengingat jadwal, tagihan, atau appointment      |

---

## Quick Start

```bash
# Clone repository ini
git clone https://github.com/whatscrm/send-whatsapp-template-php.git

# Masuk ke folder
cd send-whatsapp-template-php

# Edit API Key dan nomor tujuan
nano send-template.php

# Jalankan
php send-template.php
```

---

## About Whatscrm

**[Whatscrm](https://whatscrm.id)** menyediakan **WhatsApp Business API resmi** yang sederhana dan mudah diintegrasikan oleh developer.

Dirancang agar developer bisa langsung kirim **WhatsApp notification** tanpa konfigurasi rumit — cukup satu API call.

**Whatscrm mendukung integrasi dengan:**

- **PHP Native** — seperti contoh di repository ini
- **Laravel** — integrasi mudah via HTTP Client bawaan Laravel
- **CodeIgniter** — cocok untuk project legacy CI 3 maupun CI 4
- **Node.js** — menggunakan `axios` atau `node-fetch`
- **Python** — menggunakan `requests` library

Untuk dokumentasi lengkap, kunjungi: [https://whatscrm.id](https://whatscrm.id)

---

## Keywords

Repository ini relevan untuk pencarian:

`whatsapp api php` · `send whatsapp php` · `whatsapp business api php` · `whatsapp template message php` · `whatsapp notification php` · `whatsapp otp php` · `laravel whatsapp api` · `codeigniter whatsapp api` · `kirim whatsapp php` · `whatsapp curl php`

---

## License

[MIT License](LICENSE) — bebas digunakan untuk proyek personal maupun komersial.

---

## Contributing

Pull request dan issue sangat diterima.  
Untuk pertanyaan API, hubungi Admin Whatscrm melalui WhatsApp: **[0895361034833](https://wa.me/62895361034833)**
