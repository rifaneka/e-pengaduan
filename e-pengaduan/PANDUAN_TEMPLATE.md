# PANDUAN KUSTOMISASI TEMPLATE CETAK LAPORAN

## Cara Mengubah Template Cetak Sesuai Kategori Pengaduan

File yang perlu diedit: `/admin/template_cetak.php`

---

## 1. MENGUBAH HEADER SURAT

Edit bagian `$header_config`:

```php
$header_config['Nama Kategori'] = [
    'judul' => 'JUDUL SURAT',
    'subjek' => 'Tentang: Subjek Surat',
    'tujuan' => 'Kepada Siapa Surat Ditujukan'
];
```

**Contoh:**
```php
$header_config['Jalan Rusak'] = [
    'judul' => 'LAPORAN PENYELESAIAN PENGADUAN MASYARAKAT',
    'subjek' => 'Tentang: Perbaikan Jalan',
    'tujuan' => 'Kepala Dinas Pekerjaan Umum dan Penataan Ruang'
];
```

---

## 2. MENGUBAH KALIMAT PEMBUKA

Edit bagian `$pembuka_config`:

```php
$pembuka_config['Nama Kategori'] = 'Kalimat pembuka surat... {lokasi} akan diganti otomatis dengan lokasi pengaduan';
```

**Contoh:**
```php
$pembuka_config['Kebersihan'] = 'Menindaklanjuti laporan pengaduan masyarakat mengenai masalah kebersihan di {lokasi}, bersama ini kami sampaikan bahwa <strong>pembersihan dan penataan telah selesai dilaksanakan.</strong>';
```

**Catatan:** `{lokasi}` akan otomatis diganti dengan alamat pengaduan

---

## 3. MENGUBAH HASIL PENYELESAIAN

Edit bagian `$hasil_config`:

```php
$hasil_config['Nama Kategori'] = 'Deskripsi hasil penyelesaian masalah...';
```

**Contoh:**
```php
$hasil_config['Fasilitas Umum'] = 'Fasilitas umum telah diperbaiki dan dapat digunakan kembali dengan baik oleh masyarakat. Kondisi fasilitas sudah memenuhi standar keamanan dan kenyamanan.';
```

---

## 4. MENGUBAH TANDA TANGAN

Edit bagian `$ttd_config`:

```php
$ttd_config['Nama Kategori'] = 'Jabatan Penandatangan';
```

**Contoh:**
```php
$ttd_config['Keamanan'] = 'Kapolsek';
```

---

## 5. MENAMBAH KATEGORI BARU

### Langkah 1: Tambah Kategori di Form Pengaduan

Edit file `/user/pengaduan.php` dan `/admin/berita.php`:

```php
<select name="kategori" class="form-control" required>
    <option value="">-- Pilih Kategori --</option>
    <option value="Jalan Rusak">Jalan Rusak</option>
    <option value="Fasilitas Umum">Fasilitas Umum</option>
    <option value="Kebersihan">Kebersihan</option>
    <option value="Keamanan">Keamanan</option>
    <option value="Lampu Jalan">Lampu Jalan</option> <!-- KATEGORI BARU -->
    <option value="Lainnya">Lainnya</option>
</select>
```

### Langkah 2: Tambah Template di `template_cetak.php`

```php
// Header
$header_config['Lampu Jalan'] = [
    'judul' => 'LAPORAN PERBAIKAN LAMPU JALAN',
    'subjek' => 'Tentang: Perbaikan Lampu Jalan',
    'tujuan' => 'Kepala Dinas Listrik dan Penerangan'
];

// Pembuka
$pembuka_config['Lampu Jalan'] = 'Menindaklanjuti laporan mengenai lampu jalan yang tidak berfungsi di {lokasi}, bersama ini kami sampaikan bahwa <strong>perbaikan lampu jalan telah selesai dilaksanakan.</strong>';

// Hasil
$hasil_config['Lampu Jalan'] = 'Lampu jalan telah diperbaiki dan berfungsi dengan baik. Semua lampu telah dites dan dipastikan menyala sesuai jadwal.';

// Tanda Tangan
$ttd_config['Lampu Jalan'] = 'Kepala Dinas Listrik';
```

---

## 6. CONTOH LENGKAP KATEGORI BARU

### Kategori: Saluran Air

```php
// 1. HEADER
$header_config['Saluran Air'] = [
    'judul' => 'LAPORAN PENYELESAIAN PENGADUAN MASYARAKAT',
    'subjek' => 'Tentang: Perbaikan Saluran Air',
    'tujuan' => 'Kepala Dinas Pekerjaan Umum'
];

// 2. PEMBUKA
$pembuka_config['Saluran Air'] = 'Menindaklanjuti laporan pengaduan masyarakat mengenai masalah saluran air di {lokasi}, bersama ini kami sampaikan bahwa <strong>perbaikan saluran air telah selesai dilaksanakan.</strong>';

// 3. HASIL
$hasil_config['Saluran Air'] = 'Saluran air telah dibersihkan dan diperbaiki. Aliran air kini lancar dan tidak ada lagi genangan air di area yang dilaporkan.';

// 4. TANDA TANGAN
$ttd_config['Saluran Air'] = 'Kepala Dinas Pekerjaan Umum';
```

---

## 7. TIPS & TRIK

### Menggunakan HTML dalam Template

Anda bisa menggunakan tag HTML untuk formatting:

```php
$pembuka_config['Kategori'] = 'Text normal <strong>text tebal</strong> <em>text miring</em> text normal lagi.';
```

### Variabel yang Tersedia

Dalam template cetak, Anda memiliki akses ke variabel `$data`:

- `$data['id']` - ID pengaduan
- `$data['nama_lengkap']` - Nama pelapor
- `$data['kategori']` - Kategori pengaduan
- `$data['tanggal_pengaduan']` - Tanggal pengaduan
- `$data['alamat_pengaduan']` - Lokasi pengaduan
- `$data['deskripsi']` - Deskripsi lengkap masalah
- `$data['foto']` - Nama file foto bukti
- `$data['status']` - Status (Pending/Proses/Selesai)

### Contoh Menggunakan Variabel Custom

Jika ingin menambahkan logika khusus, edit file `/admin/cetak_pengaduan.php`

---

## 8. TESTING

Setelah mengubah template:

1. Buat pengaduan baru dengan kategori yang sudah diedit
2. Login sebagai admin
3. Buka menu "Kelola Pengaduan"
4. Klik tombol "Cetak" pada pengaduan tersebut
5. Periksa apakah template muncul sesuai yang diinginkan

---

## 9. TROUBLESHOOTING

### Template tidak berubah
- Pastikan file `template_cetak.php` sudah disimpan
- Clear cache browser (Ctrl + F5)
- Coba buka cetak dalam mode incognito

### Error muncul
- Cek syntax PHP Anda
- Pastikan semua tanda kutip ' dan " berpasangan
- Pastikan semua array diakhiri dengan ;

### Kategori tidak muncul
- Pastikan kategori ditambahkan di form pengaduan
- Pastikan nama kategori PERSIS SAMA di form dan template

---

## 10. BACKUP

Sebelum edit, SELALU backup file `template_cetak.php`:

```
Klik kanan file → Copy → Paste
Rename jadi: template_cetak_backup.php
```

---

## SUPPORT

Jika masih ada yang bingung, baca file README.md atau hubungi developer.

Selamat mengkustomisasi! 🎉
