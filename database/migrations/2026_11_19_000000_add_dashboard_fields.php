<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('problem')->nullable();
            $table->text('goal')->nullable();
            $table->string('role')->nullable();
            $table->text('features')->nullable();
            $table->text('feedback')->nullable();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Default content previously hard-coded in the page, so the site is not empty.
        $now = now();
        $img = fn ($id) => "https://images.unsplash.com/photo-$id?auto=format&fit=crop&q=80&w=600";

        DB::table('projects')->insert([
            [
                'title' => 'Sistem Manajemen Inventaris Sekolah', 'technology' => 'Laravel',
                'image' => $img('1555066931-4365d14bab8c'),
                'description' => 'Aplikasi berbasis web untuk mencatat inventaris barang laboratorium komputer dan perpustakaan sekolah secara real-time.',
                'problem' => 'Pencatatan manual menggunakan buku sering mengakibatkan selisih data dan hilangnya riwayat peminjaman.',
                'goal' => 'Mendigitalisasi proses inventaris barang dengan laporan otomatis berformat PDF dan Excel.',
                'role' => 'Full-Stack Laravel Developer',
                'features' => 'Autentikasi Multi-Level, CRUD Barang, Riwayat Peminjaman, Export Laporan',
                'feedback' => 'Sangat membantu pengelola lab dalam mendata inventaris dengan cepat.',
                'demo_link' => 'https://example.com', 'github_link' => 'https://github.com',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Aplikasi Kasir Kantin Digital (POS)', 'technology' => 'JavaScript',
                'image' => $img('1460925895917-afdab827c52f'),
                'description' => 'Aplikasi Point of Sale (POS) interaktif untuk pencatatan transaksi pesanan kantin sekolah berbasis Single Page Application.',
                'problem' => 'Antrean panjang saat jam istirahat akibat lambatnya proses kalkulasi manual pesanan makanan.',
                'goal' => 'Mempercepat transaksi dengan antarmuka kasir berbasis sentuhan dan cetak struk virtual.',
                'role' => 'Frontend & UI/UX Developer',
                'features' => 'Keranjang Belanja Dinamis, Kalkulasi Total, Riwayat Transaksi LocalStorage',
                'feedback' => 'Proses transaksi jadi lebih cepat dan terhindar dari salah hitung.',
                'demo_link' => 'https://example.com', 'github_link' => 'https://github.com',
                'created_at' => $now, 'updated_at' => $now,
            ],
            [
                'title' => 'Portal Berita & Artikel PPLG', 'technology' => 'PHP',
                'image' => $img('1499750310107-5fef28a66643'),
                'description' => 'Website portal berita interaktif bagi siswa PPLG untuk membagikan tutorial, catatan ngoding, dan dokumentasi kegiatan.',
                'problem' => 'Kurangnya wadah publikasi karya tulis teknis antar siswa di lingkungan sekolah.',
                'goal' => 'Menyediakan platform blogging internal yang ringan, cepat, dan mudah diakses.',
                'role' => 'Backend Developer',
                'features' => 'Manajemen Artikel CRUD, Komentar Pengunjung, Pencarian Artikel',
                'feedback' => 'Siswa jadi lebih aktif menulis dan mendokumentasikan kode.',
                'demo_link' => 'https://example.com', 'github_link' => 'https://github.com',
                'created_at' => $now, 'updated_at' => $now,
            ],
        ]);

        DB::table('certificates')->insert([
            ['title' => 'Juara 1 Lomba Web Design Antar Pelajar', 'issuer' => 'Dinas Pendidikan Kota', 'image' => $img('1567427017947-545c5f2d16ad'), 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Sertifikasi Kompetensi Keahlian PPLG', 'issuer' => 'BNSP & SMK Negeri 1', 'image' => $img('1523240795612-9a054b0db644'), 'created_at' => $now, 'updated_at' => $now],
            ['title' => 'Pelatihan Dasar Laravel & Database SQL', 'issuer' => 'Dicoding Indonesia', 'image' => $img('1516321318423-f06f85e504b3'), 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['problem', 'goal', 'role', 'features', 'feedback']);
        });
    }
};
