<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konseling Psikolog Profesional - MindWell</title> <!-- Judul Diperbarui -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { 
            font-family: 'Inter', sans-serif; 
            opacity: 0; 
            transform: translateY(10px);
            transition: opacity 1.2s ease-out, transform 1.2s ease-out;
            scroll-behavior: smooth; /* 🌟 Smooth scroll */
        }
        body.loaded {
            opacity: 1;
            transform: translateY(0);
        }
        .hero-bg { background-color: #f8f9fa; }

        /* Navbar Transition */
        .navbar {
            transition: all 0.4s ease-in-out;
        }
        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding-top: 0.3rem;
            padding-bottom: 0.3rem;
            backdrop-filter: blur(10px);
        }

        /* Logo Animation */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }

        /* 🌟 Highlight animasi klik link navbar */
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #4f46e5; /* indigo-600 */
            transition: width 0.3s ease-in-out;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
         /* Helper class untuk aspect ratio gambar */
        .aspect-video-call { aspect-ratio: 16 / 10; }
    </style>

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />
</head>
<body class="bg-white text-gray-800">

    <!-- Navigation Bar -->
    <nav class="navbar bg-white shadow-md sticky top-0 z-50" id="navbar" data-aos="fade-down" data-aos-duration="1000">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300">
            <div class="flex justify-between items-center h-20 transition-all duration-300">
                <!-- Logo -->
                <a href="/" class="flex-shrink-0 flex items-center space-x-2">
                    <svg class="h-8 w-8 text-indigo-600 animate-bounce-slow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-5.173-5.917M9 21a6 6 0 01-6-6v-1a6 6 0 016-6v12z" />
                    </svg>
                    <span class="text-xl font-bold text-gray-800">MindWell</span>
                </a>
                <!-- Menu Items -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="nav-link text-gray-600 hover:text-indigo-600 font-medium">Fitur</a>
                    <a href="#how-it-works" class="nav-link text-gray-600 hover:text-indigo-600 font-medium">Cara Kerja</a>
                    <a href="#counselors" class="nav-link text-gray-600 hover:text-indigo-600 font-medium">Konselor</a>
                </div>
                <!-- Login/Register Buttons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition">Login</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:scale-105 transform transition duration-300">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-bg overflow-hidden">
        <div class="max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 text-center md:text-left" data-aos="fade-right" data-aos-duration="1200">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight">
                    Dukungan Kesehatan Mental Profesional, <span class="text-indigo-600">Kapan Saja Anda Butuh.</span>
                </h1>
                <p class="mt-6 text-lg text-gray-600 max-w-xl">
                    Temukan konselor berlisensi yang tepat untuk Anda. Mulai perjalanan Anda menuju pikiran yang lebih sehat dan hidup yang lebih bahagia hari ini.
                </p>
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transform hover:scale-110 transition duration-300 ease-in-out">
                        Mulai Konseling Sekarang
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 mt-12 md:mt-0" data-aos="fade-left" data-aos-duration="1200">
                <!-- ============================================== --><!--           GAMBAR BARU DITEMPATKAN DI SINI      --><!-- ============================================== --><img src="{{ asset('storage/hero_dashboard.jpg') }}" 
                     alt="Konseling Online Profesional" 
                     class="rounded-lg shadow-2xl transform hover:scale-105 transition duration-500 object-cover aspect-video-call">
                <!-- ============================================== -->
            </div>
        </div>
    </header>

    <!-- ============================================== -->
    <!--     BAGIAN FITUR YANG HILANG (DIKEMBALIKAN)    -->
    <!-- ============================================== -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                <h2 class="text-3xl font-extrabold text-gray-900">Platform Terpercaya Anda</h2>
                <p class="mt-4 text-lg text-gray-600">Fitur yang dirancang untuk kenyamanan dan keamanan Anda.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Fitur 1: Konselor Profesional -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mx-auto shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12 12 0 003 20.944M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Konselor Berlisensi</h3>
                    <p class="mt-2 text-gray-600">Semua konselor kami telah terverifikasi, memiliki lisensi resmi, dan berpengalaman di bidangnya.</p>
                </div>
                <!-- Fitur 2: Aman & Rahasia -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mx-auto shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Aman & Rahasia</h3>
                    <p class="mt-2 text-gray-600">Privasi Anda adalah prioritas kami. Platform kami dilengkapi enkripsi untuk menjaga kerahasiaan sesi Anda.</p>
                </div>
                <!-- Fitur 3: Fleksibel -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 mx-auto shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Sesi Fleksibel</h3>
                    <p class="mt-2 text-gray-600">Pilih metode konseling yang paling nyaman bagi Anda, baik melalui Video Call ataupun Chat pribadi.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================== -->
    <!--           AKHIR BAGIAN FITUR BARU            -->
    <!-- ============================================== -->


    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                <h2 class="text-3xl font-extrabold text-gray-900">Bagaimana Cara Kerjanya?</h2>
                <p class="mt-4 text-lg text-gray-600">Hanya dalam 3 langkah mudah.</p>
            </div>
            <!-- ============================================== -->
            <!--     BAGIAN CARA KERJA (DIKEMBALIKAN)         -->
            <!-- ============================================== -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                <!-- Langkah 1 -->
                <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-100 text-indigo-600 shadow-lg">
                        <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Pilih Konselor Anda</h3>
                    <p class="mt-2 text-gray-600">Lihat profil dan jadwal konselor berlisensi kami untuk menemukan yang paling cocok untuk Anda.</p>
                </div>
                <!-- Langkah 2 -->
                <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-100 text-indigo-600 shadow-lg">
                        <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Pesan Jadwal Sesi</h3>
                    <p class="mt-2 text-gray-600">Pilih tanggal dan waktu yang sesuai dengan jadwal Anda. Pembayaran aman melalui sistem kami.</p>
                </div>
                <!-- Langkah 3 -->
                <div class="flex flex-col items-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center justify-center h-20 w-20 rounded-full bg-indigo-100 text-indigo-600 shadow-lg">
                        <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold">Mulai Sesi Anda</h3>
                    <p class="mt-2 text-gray-600">Terhubung dengan konselor Anda melalui video call atau chat aman langsung dari dashboard Anda.</p>
                </div>
            </div>
            <!-- ============================================== -->
            <!--        AKHIR BAGIAN CARA KERJA (DIKEMBALIKAN)    -->
            <!-- ============================================== -->
        </div>
    </section>

    <!-- ============================================== -->
    <!--     BAGIAN BARU CTA UNTUK KONSELOR DI SINI     -->
    <!-- ============================================== -->
    <section id="for-counselors" class="py-20 bg-gray-50"> <!-- Ganti bg-indigo-600 ke bg-gray-50 -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-3xl font-extrabold text-gray-900">Apakah Anda Seorang Konselor Profesional?</h2>
            <p class="mt-4 text-lg text-gray-600">
                Bergabunglah dengan platform kami untuk menjangkau lebih banyak pasien, mengatur jadwal Anda sendiri, dan menjadi bagian dari komunitas profesional kami.
            </p>
            <div class="mt-10">
                <a href="{{ route('counselor.register') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transform hover:scale-110 transition duration-300 ease-in-out">
                    Daftar sebagai Konselor
                </a>
            </div>
        </div>
    </section>
    <!-- ============================================== -->
    <!--           AKHIR BAGIAN BARU CTA              -->
    <!-- ============================================== -->

    <!-- Counselors Section (Dinamis) -->
    <section id="counselors" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center" data-aos="zoom-in" data-aos-duration="1000">
                <h2 class="text-3xl font-extrabold text-gray-900">Temui Beberapa Konselor Kami</h2>
                <p class="mt-4 text-lg text-gray-600">Tim profesional kami siap membantu Anda.</p>
            </div>
            
            <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                
                <!-- Loop dinamis data konselor -->
                @forelse ($counselors as $index => $counselor)
                    <div class="bg-white rounded-lg shadow-lg text-center p-6 transform hover:scale-105 hover:shadow-2xl transition duration-300" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <img class="w-24 h-24 rounded-full mx-auto object-cover" 
                             src="{{ $counselor->profile?->photo ? asset('storage/'.$counselor->profile->photo) : 'https://placehold.co/100x100/E2E8F0/94A3B8?text=Foto' }}" 
                             alt="Foto {{ $counselor->name }}">
                        <h4 class="mt-4 text-lg font-semibold">{{ $counselor->name }}</h4>
                        <p class="text-indigo-600 text-sm">{{ $counselor->profile?->specializations ?? 'Spesialis' }}</p>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500" data-aos="fade-up">
                        Saat ini belum ada konselor terverifikasi yang tersedia.
                    </p>
                @endforelse
                
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white" data-aos="fade-up" data-aos-duration="1000">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; 2025 MindWell. Semua Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        // ... (SEMUA KODE JAVASCRIPT ANDA DI SINI) ...
        AOS.init({ once: true, duration: 800, easing: 'ease-in-out' });

        window.addEventListener('load', () => {
            document.body.classList.add('loaded');
        });

        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        const links = document.querySelectorAll('.nav-link');
        links.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const targetId = link.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target) { 
                    window.scrollTo({
                        top: target.offsetTop - 80, 
                        behavior: 'smooth'
                    });
                    links.forEach(l => l.classList.remove('active'));
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>
</html>

