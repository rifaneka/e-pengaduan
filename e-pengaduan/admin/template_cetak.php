<?php

$header_config = [
    'Jalan Rusak' => [
        'judul' => 'LAPORAN PENYELESAIAN PENGADUAN MASYARAKAT',
        'subjek' => 'Tentang: Perbaikan Jalan',
        'tujuan' => 'Kepala Dinas Pekerjaan Umum dan Penataan Ruang'
    ],
    'Fasilitas Umum' => [
        'judul' => 'LAPORAN PENYELESAIAN PENGADUAN MASYARAKAT',
        'subjek' => 'Tentang: Perbaikan Fasilitas Umum',
        'tujuan' => 'Kepala Dinas Pekerjaan Umum dan Penataan Ruang'
    ],
    'Kebersihan' => [
        'judul' => 'LAPORAN PENYELESAIAN PENGADUAN MASYARAKAT',
        'subjek' => 'Tentang: Masalah Kebersihan',
        'tujuan' => 'Kepala Dinas Lingkungan Hidup'
    ],
    'Keamanan' => [
        'judul' => 'LAPORAN PENYELESAIAN PENGADUAN MASYARAKAT',
        'subjek' => 'Tentang: Masalah Keamanan',
        'tujuan' => 'Kepala Kepolisian Sektor'
    ],
    'Lainnya' => [
        'judul' => 'LAPORAN PENYELESAIAN PENGADUAN MASYARAKAT',
        'subjek' => 'Tentang: Pengaduan Masyarakat',
        'tujuan' => 'Kepala Dinas Terkait'
    ]
];

$pembuka_config = [
    'Jalan Rusak' => 'Menindaklanjuti laporan pengaduan masyarakat mengenai kondisi jalan rusak di {lokasi}, bersama ini kami sampaikan bahwa <strong>perbaikan jalan telah selesai dilaksanakan.</strong>',
    
    'Fasilitas Umum' => 'Menindaklanjuti laporan pengaduan masyarakat mengenai kerusakan fasilitas umum di {lokasi}, bersama ini kami sampaikan bahwa <strong>perbaikan fasilitas telah selesai dilaksanakan.</strong>',
    
    'Kebersihan' => 'Menindaklanjuti laporan pengaduan masyarakat mengenai masalah kebersihan di {lokasi}, bersama ini kami sampaikan bahwa <strong>pembersihan dan penataan telah selesai dilaksanakan.</strong>',
    
    'Keamanan' => 'Menindaklanjuti laporan pengaduan masyarakat mengenai masalah keamanan di {lokasi}, bersama ini kami sampaikan bahwa <strong>tindakan pengamanan telah dilaksanakan.</strong>',
    
    'Lainnya' => 'Menindaklanjuti laporan pengaduan masyarakat di {lokasi}, bersama ini kami sampaikan bahwa <strong>penanganan pengaduan telah selesai dilaksanakan.</strong>'
];

$hasil_config = [
    'Jalan Rusak' => 'Jalan kini dapat dilalui dengan aman dan lancar oleh masyarakat. Kondisi permukaan sudah rata, tidak terdapat lubang besar, dan rambu lalu lintas terpasang sesuai standar.',
    
    'Fasilitas Umum' => 'Fasilitas umum telah diperbaiki dan dapat digunakan kembali dengan baik oleh masyarakat. Kondisi fasilitas sudah memenuhi standar keamanan dan kenyamanan.',
    
    'Kebersihan' => 'Area yang dilaporkan telah dibersihkan secara menyeluruh. Sampah telah diangkut, area telah ditata kembali, dan jadwal pembersihan rutin telah dijadwalkan.',
    
    'Keamanan' => 'Langkah-langkah pengamanan telah ditingkatkan di area yang dilaporkan. Patroli rutin telah dijadwalkan dan koordinasi dengan warga setempat telah dilakukan.',
    
    'Lainnya' => 'Masalah yang dilaporkan telah ditangani sesuai dengan prosedur yang berlaku dan kondisi telah kembali normal.'
];

$ttd_config = [
    'Jalan Rusak' => 'Kepala Dinas Pekerjaan Umum',
    'Fasilitas Umum' => 'Kepala Dinas Pekerjaan Umum',
    'Kebersihan' => 'Kepala Dinas Lingkungan Hidup',
    'Keamanan' => 'Kapolsek',
    'Lainnya' => 'Kepala Dinas Terkait'
];

function getHeaderConfig($kategori) {
    global $header_config;
    return isset($header_config[$kategori]) ? $header_config[$kategori] : $header_config['Lainnya'];
}

function getPembukaText($kategori, $lokasi) {
    global $pembuka_config;
    $template = isset($pembuka_config[$kategori]) ? $pembuka_config[$kategori] : $pembuka_config['Lainnya'];
    return str_replace('{lokasi}', $lokasi, $template);
}

function getHasilText($kategori) {
    global $hasil_config;
    return isset($hasil_config[$kategori]) ? $hasil_config[$kategori] : $hasil_config['Lainnya'];
}

function getTtdText($kategori) {
    global $ttd_config;
    return isset($ttd_config[$kategori]) ? $ttd_config[$kategori] : $ttd_config['Lainnya'];
}
?>
