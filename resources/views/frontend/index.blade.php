<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio & Admin Dashboard - SMK PPLG Developer</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Inter & Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300 min-h-screen flex flex-col">

    <!-- Notification Toast -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-indigo-400 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-brand-500/20">
                    <span id="nav-initials">AP</span>
                </div>
                <div>
                    <span id="nav-brand-name" class="font-bold text-lg tracking-tight block leading-none">Atar Pratama</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">SMK PPLG Developer</span>
                </div>
            </div>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2 text-sm font-medium">
                <button onclick="switchTab('home')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 text-brand-600 dark:text-brand-400" data-target="home">Beranda</button>
                <button onclick="switchTab('about')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800" data-target="about">Tentang</button>
                <button onclick="switchTab('skills')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800" data-target="skills">Keahlian</button>
                <button onclick="switchTab('projects')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800" data-target="projects">Proyek</button>
                <button onclick="switchTab('certificates')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800" data-target="certificates">Sertifikat</button>
                <button onclick="switchTab('experience')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800" data-target="experience">Pengalaman</button>
                <button onclick="switchTab('blog')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800" data-target="blog">Catatan Ngoding</button>
                <button onclick="switchTab('contact')" class="nav-btn px-3 py-2 rounded-lg transition-colors hover:bg-slate-100 dark:hover:bg-slate-800" data-target="contact">Kontak</button>
            </nav>

            <!-- Action Tools (Theme toggle & Admin button) -->
            <div class="flex items-center space-x-2">
                <button onclick="toggleDarkMode()" class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:scale-105 transition-transform" title="Ganti Tema">
                    <i id="theme-icon" class="fa-solid fa-moon"></i>
                </button>
                <button onclick="openAdminModal()" class="flex items-center space-x-2 px-3 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-medium text-sm shadow-sm transition-all hover:scale-105">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span class="hidden sm:inline">Admin Dashboard</span>
                </button>
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Navigation -->
        <div id="mobile-menu" class="hidden md:hidden px-4 pt-2 pb-4 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col space-y-1">
            <button onclick="switchTab('home'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Beranda</button>
            <button onclick="switchTab('about'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Tentang</button>
            <button onclick="switchTab('skills'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Keahlian</button>
            <button onclick="switchTab('projects'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Proyek</button>
            <button onclick="switchTab('certificates'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Sertifikat & Prestasi</button>
            <button onclick="switchTab('experience'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Pengalaman</button>
            <button onclick="switchTab('blog'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Catatan Ngoding</button>
            <button onclick="switchTab('contact'); toggleMobileMenu()" class="text-left px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 font-medium">Kontak</button>
        </div>
    </header>

    <!-- Main Container Content Sections -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <!-- A. HALAMAN BERANDA -->
        <section id="home" class="tab-content active">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center py-10 lg:py-16">
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-brand-50 dark:bg-brand-950/60 border border-brand-200 dark:border-brand-800 text-brand-600 dark:text-brand-400 text-xs font-semibold">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span id="badge-class">XII PPLG (Pengembangan Perangkat Lunak dan Gim)</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight">
                        Halo, Saya <span id="profile-name" class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-400">Atar Pratama</span>
                    </h1>
                    <p id="profile-bio" class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed max-w-2xl">
                        Seorang Software Engineering Student yang bersemangat dalam membangun web aplikasi interaktif, sistem backend yang andal, serta eksplorasi teknologi modern.
                    </p>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <button onclick="switchTab('projects')" class="px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-medium shadow-lg shadow-brand-500/25 flex items-center space-x-2 transition-transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-code"></i>
                            <span>Lihat Portfolio</span>
                        </button>
                        <button onclick="switchTab('about')" class="px-6 py-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 font-medium flex items-center space-x-2 transition-transform hover:-translate-y-0.5">
                            <i class="fa-regular fa-file-lines text-brand-500"></i>
                            <span>Lihat CV</span>
                        </button>
                        <button onclick="switchTab('contact')" class="px-6 py-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 font-medium flex items-center space-x-2 transition-transform hover:-translate-y-0.5">
                            <i class="fa-regular fa-paper-plane text-emerald-500"></i>
                            <span>Hubungi Saya</span>
                        </button>
                    </div>

                    <!-- Key Skills mini tags -->
                    <div class="pt-6 border-t border-slate-200 dark:border-slate-800 flex items-center space-x-4">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Keahlian Utama:</span>
                        <div class="flex flex-wrap gap-2" id="home-skills-tags">
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-medium">HTML/CSS</span>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-medium">JavaScript</span>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-medium">PHP / Laravel</span>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-xs font-medium">MySQL</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative">
                        <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-brand-600 to-indigo-400 blur-xl opacity-30 animate-pulse"></div>
                        <div class="relative w-64 h-64 sm:w-80 sm:h-80 rounded-3xl overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl bg-slate-200 dark:bg-slate-800">
                            <img id="profile-avatar-img" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=600" alt="Avatar" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/400x400/4f46e5/ffffff?text=Avatar'">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- B. TENTANG SAYA / ABOUT ME -->
        <section id="about" class="tab-content">
            <div class="space-y-10 py-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Tentang Saya</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Biodata, latar belakang pendidikan, pengalaman, dan tujuan karier.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Biodata Singkat -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                        <h3 class="text-lg font-semibold flex items-center space-x-2 text-brand-600 dark:text-brand-400">
                            <i class="fa-solid fa-user-circle"></i>
                            <span>Biodata Singkat</span>
                        </h3>
                        <ul class="space-y-3 text-sm">
                            <li class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-2"><span class="text-slate-500">Nama Lengkap</span> <span id="about-fullname" class="font-medium">Atar Pratama</span></li>
                            <li class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-2"><span class="text-slate-500">Tempat, Tanggal Lahir</span> <span class="font-medium">Banjarmasin, 12 Mei 2008</span></li>
                            <li class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-2"><span class="text-slate-500">Jurusan</span> <span class="font-medium">PPLG - SMK Negeri 1</span></li>
                            <li class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-2"><span class="text-slate-500">Status</span> <span class="font-medium text-emerald-500">Siswa Aktif / Siap Magang</span></li>
                        </ul>
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Cita-Cita / Tujuan Karir</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Menjadi Full-Stack Web Developer yang profesional dan berkontribusi dalam membangun produk digital inovatif.</p>
                        </div>
                    </div>

                    <!-- Riwayat Pendidikan & Minat -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-6 lg:col-span-2">
                        <div>
                            <h3 class="text-lg font-semibold flex items-center space-x-2 text-brand-600 dark:text-brand-400 mb-4">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>Riwayat Pendidikan</span>
                            </h3>
                            <div class="space-y-4 border-l-2 border-brand-500/30 pl-4 ml-2">
                                <div>
                                    <span class="text-xs text-brand-600 dark:text-brand-400 font-semibold">2023 - Sekarang</span>
                                    <h4 class="font-bold text-base">SMK Negeri 1 PPLG</h4>
                                    <p class="text-sm text-slate-500">Fokus pada Pemrograman Web, Basis Data, Algoritma, dan Rekayasa Perangkat Lunak.</p>
                                </div>
                                <div>
                                    <span class="text-xs text-brand-600 dark:text-brand-400 font-semibold">2020 - 2023</span>
                                    <h4 class="font-bold text-base">SMP Negeri 1</h4>
                                    <p class="text-sm text-slate-500">Aktif dalam kegiatan ekstrakurikuler komputer dan sains.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                            <h3 class="text-lg font-semibold flex items-center space-x-2 text-brand-600 dark:text-brand-400 mb-3">
                                <i class="fa-solid fa-laptop-code"></i>
                                <span>Minat & Bidang Teknologi</span>
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-sm font-medium">Web Development</span>
                                <span class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-sm font-medium">Backend API Architecture</span>
                                <span class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-sm font-medium">Database Management</span>
                                <span class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-sm font-medium">UI/UX Layout Design</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- C. KEAHLIAN / SKILLS -->
        <section id="skills" class="tab-content">
            <div class="space-y-10 py-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Keahlian (Skills)</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Kemampuan teknis (Hard Skills) dan kemampuan non-teknis (Soft Skills).</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Hard Skills -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-6">
                        <h3 class="text-xl font-bold flex items-center space-x-2 text-brand-600 dark:text-brand-400">
                            <i class="fa-solid fa-code"></i>
                            <span>Hard Skills (Teknis)</span>
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>HTML5 / CSS3 / Tailwind</span> <span>95%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-brand-600 h-full rounded-full" style="width: 95%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>JavaScript (ES6+)</span> <span>88%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-brand-600 h-full rounded-full" style="width: 88%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>PHP & Laravel Framework</span> <span>85%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-brand-600 h-full rounded-full" style="width: 85%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>MySQL & Database Design</span> <span>90%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-brand-600 h-full rounded-full" style="width: 90%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>Git & GitHub Version Control</span> <span>82%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-brand-600 h-full rounded-full" style="width: 82%"></div></div>
                            </div>
                        </div>
                    </div>

                    <!-- Soft Skills -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-6">
                        <h3 class="text-xl font-bold flex items-center space-x-2 text-brand-600 dark:text-brand-400">
                            <i class="fa-solid fa-users"></i>
                            <span>Soft Skills (Non-Teknis)</span>
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>Problem Solving & Debugging</span> <span>92%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-emerald-500 h-full rounded-full" style="width: 92%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>Kerja Tim (Teamwork)</span> <span>90%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-emerald-500 h-full rounded-full" style="width: 90%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>Komunikasi Efektif</span> <span>86%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-emerald-500 h-full rounded-full" style="width: 86%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>Manajemen Waktu</span> <span>88%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-emerald-500 h-full rounded-full" style="width: 88%"></div></div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm font-medium mb-1"><span>Adaptasi Teknologi Baru</span> <span>94%</span></div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden"><div class="bg-emerald-500 h-full rounded-full" style="width: 94%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- D. GALERI PROJEK & FITUR TAMBAHAN (Pencarian & Filter) -->
        <section id="projects" class="tab-content">
            <div class="space-y-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight">Galeri Projek</h2>
                        <p class="text-slate-500 dark:text-slate-400 mt-1">Kumpulan proyek aplikasi dan sistem yang telah dikembangkan.</p>
                    </div>
                    <!-- Fitur Tambahan: Pencarian dan Filter -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-3.5 top-3 text-slate-400"></i>
                            <input type="text" id="project-search" oninput="filterProjects()" placeholder="Cari proyek..." class="pl-10 pr-4 py-2 w-full sm:w-60 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        </div>
                        <select id="project-category-filter" onchange="filterProjects()" class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                            <option value="all">Semua Teknologi</option>
                            <option value="Laravel">Laravel</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="PHP">PHP</option>
                        </select>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div id="projects-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Dynamic project cards injected via JS -->
                </div>
            </div>
        </section>

        <!-- E. SERTIFIKAT DAN PRESTASI -->
        <section id="certificates" class="tab-content">
            <div class="space-y-8 py-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Sertifikat & Prestasi</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Penghargaan lomba, sertifikasi kompetensi, dan pelatihan industri.</p>
                </div>

                <div id="certificates-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Dynamic certificates injected via JS -->
                </div>
            </div>
        </section>

        <!-- F. PENGALAMAN / EXPERIENCE -->
        <section id="experience" class="tab-content">
            <div class="space-y-8 py-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Pengalaman</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Pengalaman Praktek Kerja Lapangan (PKL), organisasi, dan partisipasi lomba.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <h3 class="text-lg font-bold">PKL (Praktik Kerja Lapangan)</h3>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-brand-50 dark:bg-brand-950 text-brand-600 inline-block">PT. Teknologi Solusi Nusantara</span>
                        <p class="text-sm text-slate-500">Membantu tim developer dalam maintenance sistem berbasis web, membuat REST API sederhana, dan integrasi database.</p>
                    </div>
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-users-rectangle"></i>
                        </div>
                        <h3 class="text-lg font-bold">Pengalaman Organisasi</h3>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-950 text-emerald-600 inline-block">Sekretaris OSIS & IT Club</span>
                        <p class="text-sm text-slate-500">Mengkoordinasikan kegiatan workshop coding mingguan untuk siswa tingkat dasar dan mengatur dokumentasi acara sekolah.</p>
                    </div>
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <h3 class="text-lg font-bold">Pengalaman Lomba</h3>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-amber-50 dark:bg-amber-950 text-amber-600 inline-block">LKS Web Technologies Tingkat Kota</span>
                        <p class="text-sm text-slate-500">Berpartisipasi dalam kompetisi keahlian siswa bidang pengembangan web, merancang sistem fungsional dalam batasan waktu ketat.</p>
                    </div>
                </div>

                <!-- M. TESTIMONY -->
                <div class="pt-8">
                    <h3 class="text-2xl font-bold mb-6">Testimoni & Penilaian</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-3">
                            <p class="text-sm italic text-slate-600 dark:text-slate-300">"Atar adalah siswa yang sangat inisiatif dan cepat menguasai framework Laravel selama pembimbingan."</p>
                            <div>
                                <h4 class="font-bold text-sm">Bpk. Ahmad Fauzi, M.Kom</h4>
                                <span class="text-xs text-slate-400">Guru Pembimbing PPLG</span>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-3">
                            <p class="text-sm italic text-slate-600 dark:text-slate-300">"Partner kelompok yang sangat diandalkan saat mengerjakan projek aplikasi inventaris sekolah."</p>
                            <div>
                                <h4 class="font-bold text-sm">Rizky Ramadhan</h4>
                                <span class="text-xs text-slate-400">Teman Seangkatan PPLG</span>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-3">
                            <p class="text-sm italic text-slate-600 dark:text-slate-300">"Aplikasi kasir yang dibuat Atar sangat intuitif dan membantu mempercepat transaksi di kantin."</p>
                            <div>
                                <h4 class="font-bold text-sm">Ibu Siti Aminah</h4>
                                <span class="text-xs text-slate-400">Pengguna / Mitra Kantin</span>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-3">
                            <p class="text-sm italic text-slate-600 dark:text-slate-300">"Etos kerja selama PKL sangat baik, disiplin, dan mampu menyelesaikan tugas tepat waktu."</p>
                            <div>
                                <h4 class="font-bold text-sm">Mentor PKL</h4>
                                <span class="text-xs text-slate-400">PT. Teknologi Solusi Nusantara</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- N. BLOG PENGEMBANG / ARTIKEL / CATATAN NGODING -->
        <section id="blog" class="tab-content">
            <div class="space-y-8 py-6">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Catatan Ngoding & Artikel</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Dokumentasi pemecahan masalah coding, tips pemrograman, dan jurnal belajar.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded bg-indigo-50 dark:bg-indigo-950 text-indigo-600">Laravel Tips</span>
                            <h3 class="text-lg font-bold">Mengatasi Error CSRF Token Mismatch pada Laravel AJAX Request</h3>
                            <p class="text-sm text-slate-500">Cara menyisipkan header meta CSRF token ke dalam setiap skrip AJAX agar request POST berhasil diproses oleh middleware.</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-400">
                            <span>15 Mei 2026</span>
                            <span class="font-medium text-brand-600">Baca Selengkapnya →</span>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded bg-emerald-50 dark:bg-emerald-950 text-emerald-600">JavaScript ES6</span>
                            <h3 class="text-lg font-bold">Memahami Konsep Asynchronous JavaScript: Async/Await vs Promises</h3>
                            <p class="text-sm text-slate-500">Penjelasan sederhana bagaimana menangani data API eksternal tanpa membuat blocking pada halaman web browser.</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-400">
                            <span>28 April 2026</span>
                            <span class="font-medium text-brand-600">Baca Selengkapnya →</span>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded bg-amber-50 dark:bg-amber-950 text-amber-600">CSS / Tailwind</span>
                            <h3 class="text-lg font-bold">Tips Responsive Design Menggunakan Grid & Flexbox di Tailwind</h3>
                            <p class="text-sm text-slate-500">Panduan praktis mengatur tata letak agar tetap rapi dari layar smartphone hingga monitor ultrawide.</p>
                        </div>
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-between items-center text-xs text-slate-400">
                            <span>10 April 2026</span>
                            <span class="font-medium text-brand-600">Baca Selengkapnya →</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- H. KONTAK & I. FORMULIR KESAN DAN PESAN -->
        <section id="contact" class="tab-content">
            <div class="space-y-8 py-6 max-w-4xl mx-auto">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight">Hubungi Saya</h2>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Terhubung melalui sosial media atau kirimkan pesan & kesan melalui formulir di bawah.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="mailto:atar@example.com" class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center space-x-4 shadow-sm hover:border-brand-500 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-950/60 text-red-500 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">Email Resmi</span>
                            <span class="font-medium text-sm">atar@example.com</span>
                        </div>
                    </a>
                    <a href="https://github.com" target="_blank" class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center space-x-4 shadow-sm hover:border-brand-500 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 flex items-center justify-center text-xl">
                            <i class="fa-brands fa-github"></i>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">GitHub</span>
                            <span class="font-medium text-sm">github.com/atarpplg</span>
                        </div>
                    </a>
                    <a href="https://linkedin.com" target="_blank" class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center space-x-4 shadow-sm hover:border-brand-500 transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-500 flex items-center justify-center text-xl">
                            <i class="fa-brands fa-linkedin"></i>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 block">LinkedIn</span>
                            <span class="font-medium text-sm">Atar Pratama</span>
                        </div>
                    </a>
                </div>

                <!-- Formulir Kesan dan Pesan -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <h3 class="text-xl font-bold mb-4 flex items-center space-x-2 text-brand-600 dark:text-brand-400">
                        <i class="fa-regular fa-comment-dots"></i>
                        <span>Formulir Kesan dan Pesan</span>
                    </h3>
                    <form onsubmit="handleMessageSubmit(event)" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Nama Lengkap</label>
                                <input type="text" id="msg-name" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" placeholder="Nama Anda...">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Email / Kontak</label>
                                <input type="email" id="msg-email" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" placeholder="email@domain.com">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Kesan & Pesan / Pertanyaan</label>
                            <textarea id="msg-text" rows="4" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" placeholder="Tuliskan kesan, pesan, atau masukan untuk portfolio ini..."></textarea>
                        </div>
                        <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl shadow-md transition-all">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer with Top Back Button -->
    <footer class="mt-auto border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 py-8 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Atar Pratama. SMK PPLG Developer Portfolio. All rights reserved.</p>
            <button onclick="scrollToTop()" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-medium hover:bg-brand-50 dark:hover:bg-slate-700 flex items-center space-x-2">
                <i class="fa-solid fa-arrow-up"></i>
                <span>Kembali ke Atas</span>
            </button>
        </div>
    </footer>

    <!-- Project Detail Modal -->
    <div id="project-modal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 sm:p-8 space-y-6 shadow-2xl">
            <div class="flex justify-between items-start">
                <div>
                    <span id="modal-project-tech" class="text-xs font-semibold px-2.5 py-1 rounded bg-brand-50 dark:bg-brand-950 text-brand-600">Teknologi</span>
                    <h3 id="modal-project-title" class="text-2xl font-bold mt-2">Judul Proyek</h3>
                </div>
                <button onclick="closeProjectModal()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-slate-800">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            <div class="rounded-2xl overflow-hidden h-60 bg-slate-100 dark:bg-slate-800">
                <img id="modal-project-img" src="" alt="Project Preview" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/600x400/4f46e5/ffffff?text=Project'">
            </div>
            <div class="space-y-4 text-sm text-slate-600 dark:text-slate-300">
                <div>
                    <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-1">Deskripsi Proyek</h4>
                    <p id="modal-project-desc">-</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                        <strong class="block text-xs font-bold uppercase text-brand-600 mb-1">Permasalahan</strong>
                        <span id="modal-project-problem">-</span>
                    </div>
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                        <strong class="block text-xs font-bold uppercase text-emerald-600 mb-1">Tujuan</strong>
                        <span id="modal-project-goal">-</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-1">Peran & Fitur Utama</h4>
                    <p id="modal-project-role" class="mb-2"><strong class="text-slate-700 dark:text-slate-300">Peran:</strong> -</p>
                    <p id="modal-project-features">-</p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 dark:text-slate-100 mb-1">Feedback User</h4>
                    <p id="modal-project-feedback" class="italic">-</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                <a id="modal-project-demo" href="#" target="_blank" class="px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-medium text-sm flex items-center space-x-2">
                    <i class="fa-solid fa-external-link"></i><span>Link Demo</span>
                </a>
                <a id="modal-project-github" href="#" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-medium text-sm flex items-center space-x-2">
                    <i class="fa-brands fa-github"></i><span>Source Code</span>
                </a>
            </div>
        </div>
    </div>

    <!-- L. DASHBOARD ADMIN MODAL -->
    <div id="admin-modal" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-5xl w-full max-h-[92vh] overflow-y-auto p-6 sm:p-8 space-y-6 shadow-2xl">
            <!-- Login View -->
            <div id="admin-login-view" class="max-w-md mx-auto py-10 space-y-6">
                <div class="text-center space-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-brand-50 dark:bg-brand-950 text-brand-600 flex items-center justify-center text-2xl mx-auto shadow-inner">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <h3 class="text-2xl font-bold">Admin Dashboard Login</h3>
                    <p class="text-sm text-slate-500">Masukkan kredensial untuk mengelola konten portfolio.</p>
                </div>
                <form onsubmit="handleAdminLogin(event)" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Username</label>
                        <input type="text" id="admin-user" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Password</label>
                        <input type="password" id="admin-pass" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    </div>
                    <button type="submit" class="w-full py-3 bg-brand-600 hover:bg-brand-700 text-white font-medium rounded-xl shadow-lg transition-all">
                        Login Dashboard
                    </button>
                    <button type="button" onclick="closeAdminModal()" class="w-full py-2.5 bg-transparent text-slate-500 hover:text-slate-800 text-sm font-medium">
                        Tutup & Kembali
                    </button>
                </form>
            </div>

            <!-- Dashboard Panel View (CRUD & Management) -->
            <div id="admin-panel-view" class="hidden space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
                    <div>
                        <h3 class="text-2xl font-bold">Admin Control Panel</h3>
                        <p class="text-sm text-slate-500">Kelola informasi profil, CRUD proyek, sertifikat, dan kotak masuk pesan.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="adminLogout()" class="px-4 py-2 rounded-xl bg-red-50 dark:bg-red-950/60 text-red-600 text-sm font-medium">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                        </button>
                        <button onclick="closeAdminModal()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>

                <!-- Admin Tabs / Sub-sections -->
                <div class="flex flex-wrap gap-2 border-b border-slate-200 dark:border-slate-800 pb-3">
                    <button onclick="switchAdminTab('projects')" id="adm-tab-projects" class="admin-subtab px-4 py-2 rounded-xl bg-brand-600 text-white text-sm font-medium">Kelola Proyek (CRUD)</button>
                    <button onclick="switchAdminTab('profile')" id="adm-tab-profile" class="admin-subtab px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-medium">Informasi Profil</button>
                    <button onclick="switchAdminTab('certificates')" id="adm-tab-certificates" class="admin-subtab px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-medium">Sertifikat</button>
                    <button onclick="switchAdminTab('messages')" id="adm-tab-messages" class="admin-subtab px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-medium">Kotak Masuk Pesan</button>
                </div>

                <!-- Sub-content: Projects CRUD -->
                <div id="adm-content-projects" class="admin-subcontent space-y-6">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-lg">Daftar Proyek Portfolio</h4>
                        <button onclick="openProjectFormModal()" class="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium flex items-center space-x-2">
                            <i class="fa-solid fa-plus"></i><span>Tambah Proyek Baru</span>
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-100 dark:bg-slate-800 text-slate-500">
                                <tr>
                                    <th class="p-3 rounded-l-xl">Proyek</th>
                                    <th class="p-3">Teknologi</th>
                                    <th class="p-3">Peran</th>
                                    <th class="p-3 rounded-r-xl text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="admin-projects-table-body" class="divide-y divide-slate-100 dark:divide-slate-800">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sub-content: Profile Management -->
                <div id="adm-content-profile" class="admin-subcontent space-y-6 hidden">
                    <h4 class="font-bold text-lg">Kelola Informasi Profil</h4>
                    <form onsubmit="handleProfileUpdate(event)" class="space-y-4 max-w-2xl">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Nama Lengkap</label>
                            <input type="text" id="admin-edit-name" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm" value="Atar Pratama">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Kelas / Kompetensi</label>
                            <input type="text" id="admin-edit-class" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm" value="XII PPLG (Pengembangan Perangkat Lunak dan Gim)">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Deskripsi Singkat / Personal Branding</label>
                            <textarea id="admin-edit-bio" rows="3" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">Seorang Software Engineering Student yang bersemangat dalam membangun web aplikasi interaktif, sistem backend yang andal, serta eksplorasi teknologi modern.</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">URL Foto Profil / Avatar</label>
                            <input type="url" id="admin-edit-avatar" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm" value="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=600">
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-brand-600 text-white rounded-xl text-sm font-medium shadow">Simpan Perubahan Profil</button>
                    </form>
                </div>

                <!-- Sub-content: Certificates Management -->
                <div id="adm-content-certificates" class="admin-subcontent space-y-6 hidden">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-lg">Kelola Sertifikat & Prestasi</h4>
                        <button onclick="openCertificateFormModal()" class="px-4 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium flex items-center space-x-2">
                            <i class="fa-solid fa-plus"></i><span>Tambah Sertifikat</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="admin-certificates-grid">
                        <!-- Dynamic list -->
                    </div>
                </div>

                <!-- Sub-content: Messages Inbox -->
                <div id="adm-content-messages" class="admin-subcontent space-y-6 hidden">
                    <h4 class="font-bold text-lg">Kotak Masuk Pesan & Kesan Pengunjung</h4>
                    <div class="space-y-4" id="admin-messages-list">
                        <!-- Dynamic messages -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Form Modal (Add / Edit) -->
    <div id="project-form-modal" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 sm:p-8 space-y-6 shadow-2xl">
            <div class="flex justify-between items-center">
                <h3 id="project-form-title" class="text-xl font-bold">Tambah Proyek Baru</h3>
                <button onclick="closeProjectFormModal()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form onsubmit="handleProjectFormSubmit(event)" class="space-y-4">
                <input type="hidden" id="pf-id">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Nama Proyek</label>
                        <input type="text" id="pf-name" required class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Kategori / Teknologi</label>
                        <select id="pf-category" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                            <option value="Laravel">Laravel</option>
                            <option value="JavaScript">JavaScript</option>
                            <option value="PHP">PHP</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">URL Gambar</label>
                    <input type="url" id="pf-img" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Deskripsi Proyek</label>
                    <textarea id="pf-desc" rows="2" required class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm"></textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Masalah</label>
                        <textarea id="pf-problem" rows="2" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Tujuan</label>
                        <textarea id="pf-goal" rows="2" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Peran</label>
                        <input type="text" id="pf-role" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Fitur</label>
                        <input type="text" id="pf-features" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Feedback</label>
                    <input type="text" id="pf-feedback" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Link Demo</label>
                        <input type="url" id="pf-demo" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Link GitHub</label>
                        <input type="url" id="pf-github" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm">
                    </div>
                </div>
                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeProjectFormModal()" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl text-sm font-medium">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium">Simpan Permanen ke Database</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Certificate Form Modal -->
    <div id="certificate-form-modal" class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold">Tambah Sertifikat Baru</h3>
                <button onclick="closeCertificateFormModal()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form onsubmit="handleCertificateFormSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Nama Sertifikat / Prestasi</label>
                    <input type="text" id="cf-title" required class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm" placeholder="Juara 1 Web Design...">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Penerbit / Penyelenggara</label>
                    <input type="text" id="cf-issuer" required class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm" placeholder="Dinas Pendidikan / Udemy">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">URL Gambar Dokumentasi Sertifikat</label>
                    <input type="url" id="cf-img" required class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeCertificateFormModal()" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 rounded-xl text-sm font-medium">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-brand-600 text-white rounded-xl text-sm font-medium">Simpan Sertifikat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript Application Logic -->
    <script>
        // Data comes from the database (rendered by the server)
        let portfolioData = @json($data);
        const IS_ADMIN = portfolioData.isAdmin;

        async function api(method, url, body) {
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: body ? JSON.stringify(body) : undefined
            });
            if (!res.ok) {
                let msg = 'Gagal menyimpan (' + res.status + ')';
                try { const j = await res.json(); msg = j.message || msg; } catch (e) {}
                throw new Error(msg);
            }
            return res.json();
        }

        // Initialize application on load
        window.onload = function() {
            renderProfile();
            renderProjects();
            renderCertificates();
            renderAdminMessages();
            renderAdminProjectsTable();
            renderAdminCertificatesGrid();
            if (IS_ADMIN) showAdminPanel();
        };

        async function showAdminPanel() {
            document.getElementById('admin-login-view').classList.add('hidden');
            document.getElementById('admin-panel-view').classList.remove('hidden');
            try {
                portfolioData.messages = await api('GET', '/admin/messages');
                renderAdminMessages();
            } catch (e) {}
        }

        // Tab Switching Logic
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.nav-btn').forEach(el => {
                el.classList.remove('text-brand-600', 'dark:text-brand-400', 'bg-slate-100', 'dark:bg-slate-800');
            });

            const targetTab = document.getElementById(tabId);
            if (targetTab) {
                targetTab.classList.add('active');
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Highlight active nav button
            document.querySelectorAll('.nav-btn').forEach(btn => {
                if (btn.getAttribute('data-target') === tabId) {
                    btn.classList.add('text-brand-600', 'dark:text-brand-400', 'bg-slate-100', 'dark:bg-slate-800');
                }
            });
        }

        // Toggle Dark / Light Mode
        function toggleDarkMode() {
            const html = document.documentElement;
            html.classList.toggle('dark');
            const icon = document.getElementById('theme-icon');
            if (html.classList.contains('dark')) {
                icon.className = "fa-solid fa-sun";
            } else {
                icon.className = "fa-solid fa-moon";
            }
        }

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Scroll to Top helper
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Render Profile data to UI
        function renderProfile() {
            const p = portfolioData.profile;
            document.getElementById('nav-brand-name').innerText = p.name;
            document.getElementById('nav-initials').innerText = p.name.split(' ').map(n => n[0]).join('').substring(0, 2);
            document.getElementById('profile-name').innerText = p.name;
            document.getElementById('badge-class').innerText = p.classInfo;
            document.getElementById('profile-bio').innerText = p.bio;
            document.getElementById('profile-avatar-img').src = p.avatar;
            document.getElementById('about-fullname').innerText = p.name;

            // Sync admin form inputs
            document.getElementById('admin-edit-name').value = p.name;
            document.getElementById('admin-edit-class').value = p.classInfo;
            document.getElementById('admin-edit-bio').value = p.bio;
            document.getElementById('admin-edit-avatar').value = p.avatar;
        }

        // Render Projects Gallery with Filtering & Search
        function renderProjects(filteredList = null) {
            const grid = document.getElementById('projects-grid');
            const list = filteredList || portfolioData.projects;

            if (list.length === 0) {
                grid.innerHTML = `<div class="col-span-full py-12 text-center text-slate-400">Tidak ada proyek yang ditemukan.</div>`;
                return;
            }

            grid.innerHTML = list.map(proj => `
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between group hover:border-brand-500/50 transition-all">
                    <div>
                        <div class="h-48 overflow-hidden bg-slate-100 dark:bg-slate-800 relative">
                            <img src="${proj.image}" alt="${proj.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://placehold.co/600x400/4f46e5/ffffff?text=Project'">
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-lg bg-slate-900/70 backdrop-blur-md text-white text-xs font-semibold">${proj.category}</span>
                        </div>
                        <div class="p-6 space-y-3">
                            <h3 class="font-bold text-lg group-hover:text-brand-600 transition-colors">${proj.name}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2">${proj.description}</p>
                        </div>
                    </div>
                    <div class="p-6 pt-0 flex items-center justify-between">
                        <button onclick="openProjectModal(${proj.id})" class="px-4 py-2 rounded-xl bg-brand-50 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 text-sm font-medium hover:bg-brand-100 transition-colors">
                            Detail Proyek
                        </button>
                        <div class="flex space-x-2">
                            <a href="${proj.demo}" target="_blank" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-brand-600" title="Demo"><i class="fa-solid fa-external-link"></i></a>
                            <a href="${proj.github}" target="_blank" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-brand-600" title="GitHub"><i class="fa-brands fa-github"></i></a>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function filterProjects() {
            const query = document.getElementById('project-search').value.toLowerCase();
            const cat = document.getElementById('project-category-filter').value;

            const filtered = portfolioData.projects.filter(p => {
                const matchQuery = p.name.toLowerCase().includes(query) || p.description.toLowerCase().includes(query);
                const matchCat = cat === 'all' || p.category === cat;
                return matchQuery && matchCat;
            });

            renderProjects(filtered);
        }

        // Open Project Detail Modal
        function openProjectModal(id) {
            const proj = portfolioData.projects.find(p => p.id === id);
            if (!proj) return;

            document.getElementById('modal-project-tech').innerText = proj.category;
            document.getElementById('modal-project-title').innerText = proj.name;
            document.getElementById('modal-project-img').src = proj.image;
            document.getElementById('modal-project-desc').innerText = proj.description;
            document.getElementById('modal-project-problem').innerText = proj.problem;
            document.getElementById('modal-project-goal').innerText = proj.goal;
            document.getElementById('modal-project-role').innerHTML = `<strong class="text-slate-700 dark:text-slate-300">Peran:</strong> ${proj.role} <br><strong class="text-slate-700 dark:text-slate-300 mt-1 block">Fitur:</strong> ${proj.features}`;
            document.getElementById('modal-project-feedback').innerText = `"${proj.feedback}"`;
            document.getElementById('modal-project-demo').href = proj.demo;
            document.getElementById('modal-project-github').href = proj.github;

            document.getElementById('project-modal').classList.remove('hidden');
            document.getElementById('project-modal').classList.add('flex');
        }

        function closeProjectModal() {
            document.getElementById('project-modal').classList.remove('flex');
            document.getElementById('project-modal').classList.add('hidden');
        }

        // Render Certificates
        function renderCertificates() {
            const grid = document.getElementById('certificates-grid');
            grid.innerHTML = portfolioData.certificates.map(c => `
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="h-48 overflow-hidden bg-slate-100 dark:bg-slate-800">
                        <img src="${c.image}" alt="${c.title}" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/600x400/4f46e5/ffffff?text=Certificate'">
                    </div>
                    <div class="p-6 space-y-2">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950 text-emerald-600">${c.issuer}</span>
                        <h3 class="font-bold text-lg">${c.title}</h3>
                    </div>
                </div>
            `).join('');
        }

        // Contact Form Message Submit
        async function handleMessageSubmit(e) {
            e.preventDefault();
            const form = e.target;
            try {
                await api('POST', '/messages', {
                    name: document.getElementById('msg-name').value,
                    email: document.getElementById('msg-email').value,
                    text: document.getElementById('msg-text').value
                });
                showToast("Pesan & kesan berhasil dikirim ke Admin!");
                form.reset();
            } catch (err) { showToast(err.message); }
        }

        // Toast Notification Helper
        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = "px-4 py-3 rounded-xl bg-slate-900 text-white dark:bg-white dark:text-slate-900 text-sm font-medium shadow-lg animate-bounce";
            toast.innerText = message;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        // Admin Modal Controls
        function openAdminModal() {
            document.getElementById('admin-modal').classList.remove('hidden');
            document.getElementById('admin-modal').classList.add('flex');
        }

        function closeAdminModal() {
            document.getElementById('admin-modal').classList.remove('flex');
            document.getElementById('admin-modal').classList.add('hidden');
        }

        async function handleAdminLogin(e) {
            e.preventDefault();
            try {
                const r = await api('POST', '/admin/login', {
                    username: document.getElementById('admin-user').value,
                    password: document.getElementById('admin-pass').value
                });
                portfolioData.messages = r.messages;
                renderAdminMessages();
                document.getElementById('admin-login-view').classList.add('hidden');
                document.getElementById('admin-panel-view').classList.remove('hidden');
                showToast("Login Admin Berhasil!");
            } catch (err) { showToast(err.message); }
        }

        async function adminLogout() {
            try { await api('POST', '/admin/logout'); } catch (e) {}
            document.getElementById('admin-panel-view').classList.add('hidden');
            document.getElementById('admin-login-view').classList.remove('hidden');
            showToast("Berhasil Logout Admin.");
        }

        // Admin Sub-tabs switching
        function switchAdminTab(tab) {
            document.querySelectorAll('.admin-subcontent').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.admin-subtab').forEach(el => {
                el.classList.remove('bg-brand-600', 'text-white');
                el.classList.add('bg-slate-100', 'dark:bg-slate-800', 'text-slate-600', 'dark:text-slate-300');
            });

            document.getElementById(`adm-content-${tab}`).classList.remove('hidden');
            const activeBtn = document.getElementById(`adm-tab-${tab}`);
            activeBtn.classList.remove('bg-slate-100', 'dark:bg-slate-800', 'text-slate-600', 'dark:text-slate-300');
            activeBtn.classList.add('bg-brand-600', 'text-white');
        }

        // Admin Projects CRUD Table
        function renderAdminProjectsTable() {
            const tbody = document.getElementById('admin-projects-table-body');
            tbody.innerHTML = portfolioData.projects.map(p => `
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                    <td class="p-3 font-medium flex items-center space-x-3">
                        <img src="${p.image}" class="w-10 h-10 rounded-lg object-cover" onerror="this.src='https://placehold.co/100x100'">
                        <div>
                            <div class="font-bold">${p.name}</div>
                            <div class="text-xs text-slate-400">ID: ${p.id}</div>
                        </div>
                    </td>
                    <td class="p-3"><span class="px-2 py-0.5 rounded bg-brand-50 dark:bg-brand-950 text-brand-600 text-xs">${p.category}</span></td>
                    <td class="p-3 text-slate-500">${p.role}</td>
                    <td class="p-3 text-right space-x-2">
                        <button onclick="editProject(${p.id})" class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-brand-600 hover:bg-brand-50" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <button onclick="deleteProject(${p.id})" class="p-2 rounded-lg bg-red-50 dark:bg-red-950/60 text-red-600 hover:bg-red-100" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            `).join('');
        }

        function openProjectFormModal(id = null) {
            document.getElementById('project-form-modal').classList.remove('hidden');
            document.getElementById('project-form-modal').classList.add('flex');
            if (id) {
                document.getElementById('project-form-title').innerText = "Edit Proyek";
                const p = portfolioData.projects.find(x => x.id === id);
                document.getElementById('pf-id').value = p.id;
                document.getElementById('pf-name').value = p.name;
                document.getElementById('pf-category').value = p.category;
                document.getElementById('pf-img').value = p.image;
                document.getElementById('pf-desc').value = p.description;
                document.getElementById('pf-problem').value = p.problem;
                document.getElementById('pf-goal').value = p.goal;
                document.getElementById('pf-role').value = p.role;
                document.getElementById('pf-feedback').value = p.feedback;
                document.getElementById('pf-features').value = p.features;
                document.getElementById('pf-demo').value = p.demo;
                document.getElementById('pf-github').value = p.github;
            } else {
                document.getElementById('project-form-title').innerText = "Tambah Proyek Baru";
                document.getElementById('pf-id').value = "";
                document.querySelector('#project-form-modal form').reset();
            }
        }

        function closeProjectFormModal() {
            document.getElementById('project-form-modal').classList.remove('flex');
            document.getElementById('project-form-modal').classList.add('hidden');
        }

        async function handleProjectFormSubmit(e) {
            e.preventDefault();
            const id = document.getElementById('pf-id').value;
            const payload = {
                name: document.getElementById('pf-name').value,
                category: document.getElementById('pf-category').value,
                image: document.getElementById('pf-img').value,
                description: document.getElementById('pf-desc').value,
                problem: document.getElementById('pf-problem').value,
                goal: document.getElementById('pf-goal').value,
                role: document.getElementById('pf-role').value,
                feedback: document.getElementById('pf-feedback').value,
                features: document.getElementById('pf-features').value,
                demo: document.getElementById('pf-demo').value,
                github: document.getElementById('pf-github').value
            };
            try {
                if (id) {
                    const saved = await api('PUT', '/admin/projects/' + id, payload);
                    const idx = portfolioData.projects.findIndex(x => x.id === parseInt(id));
                    portfolioData.projects[idx] = saved;
                    showToast("Proyek berhasil diperbarui!");
                } else {
                    portfolioData.projects.unshift(await api('POST', '/admin/projects', payload));
                    showToast("Proyek baru berhasil ditambahkan!");
                }
            } catch (err) { showToast(err.message); return; }

            closeProjectFormModal();
            renderProjects();
            renderAdminProjectsTable();
        }

        function editProject(id) {
            openProjectFormModal(id);
        }

        async function deleteProject(id) {
            if (!confirm("Apakah Anda yakin ingin menghapus proyek ini?")) return;
            try { await api('DELETE', '/admin/projects/' + id); } catch (err) { showToast(err.message); return; }
            portfolioData.projects = portfolioData.projects.filter(p => p.id !== id);
            renderProjects();
            renderAdminProjectsTable();
            showToast("Proyek berhasil dihapus.");
        }

        // Profile Update Handler
        async function handleProfileUpdate(e) {
            e.preventDefault();
            try {
                portfolioData.profile = await api('PUT', '/admin/profile', {
                    name: document.getElementById('admin-edit-name').value,
                    classInfo: document.getElementById('admin-edit-class').value,
                    bio: document.getElementById('admin-edit-bio').value,
                    avatar: document.getElementById('admin-edit-avatar').value
                });
            } catch (err) { showToast(err.message); return; }
            renderProfile();
            showToast("Informasi profil berhasil diperbarui!");
        }

        // Certificates Management in Admin
        function renderAdminCertificatesGrid() {
            const grid = document.getElementById('admin-certificates-grid');
            grid.innerHTML = portfolioData.certificates.map(c => `
                <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="${c.image}" class="w-12 h-12 rounded-lg object-cover">
                        <div>
                            <h5 class="font-bold text-sm">${c.title}</h5>
                            <span class="text-xs text-slate-400">${c.issuer}</span>
                        </div>
                    </div>
                    <button onclick="deleteCertificate(${c.id})" class="p-2 rounded-lg bg-red-50 dark:bg-red-950 text-red-600"><i class="fa-solid fa-trash"></i></button>
                </div>
            `).join('');
        }

        function openCertificateFormModal() {
            document.getElementById('certificate-form-modal').classList.remove('hidden');
            document.getElementById('certificate-form-modal').classList.add('flex');
        }

        function closeCertificateFormModal() {
            document.getElementById('certificate-form-modal').classList.remove('flex');
            document.getElementById('certificate-form-modal').classList.add('hidden');
        }

        async function handleCertificateFormSubmit(e) {
            e.preventDefault();
            try {
                portfolioData.certificates.unshift(await api('POST', '/admin/certificates', {
                    title: document.getElementById('cf-title').value,
                    issuer: document.getElementById('cf-issuer').value,
                    image: document.getElementById('cf-img').value
                }));
            } catch (err) { showToast(err.message); return; }
            closeCertificateFormModal();
            renderCertificates();
            renderAdminCertificatesGrid();
            showToast("Sertifikat baru ditambahkan!");
        }

        async function deleteCertificate(id) {
            try { await api('DELETE', '/admin/certificates/' + id); } catch (err) { showToast(err.message); return; }
            portfolioData.certificates = portfolioData.certificates.filter(c => c.id !== id);
            renderCertificates();
            renderAdminCertificatesGrid();
            showToast("Sertifikat dihapus.");
        }

        // Messages Inbox Render
        function renderAdminMessages() {
            const list = document.getElementById('admin-messages-list');
            if (portfolioData.messages.length === 0) {
                list.innerHTML = `<p class="text-slate-400 text-sm">Belum ada pesan masuk.</p>`;
                return;
            }
            list.innerHTML = portfolioData.messages.map(m => `
                <div class="p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl space-y-2">
                    <div class="flex justify-between items-center text-xs text-slate-400">
                        <strong class="text-slate-800 dark:text-slate-200 text-sm">${m.name} (${m.email})</strong>
                        <span>${m.date}</span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-300">"${m.text}"</p>
                </div>
            `).join('');
        }
    </script>
</body>
</html>