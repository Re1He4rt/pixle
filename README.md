# Pixel Search Engine 🔍🎨

Mesin pencari (Search Engine) kustom bergaya **Google Material You (Pixel)**. Dibangun dari nol untuk mengeksplorasi integrasi Full-Stack, animasi UI lanjutan, dan API pihak ketiga.

## ✨ Fitur Utama
- **Pencarian Real-time**: Terintegrasi dengan Tavily Search API.
- **Pixel Transition Animation**: Animasi transisi grid piksel yang mulus (Vanilla JS & CSS).
- **Adaptive Speed**: Kecepatan animasi menyesuaikan kecepatan jaringan pengguna (Network Information API).
- **Material You UI**: Desain antarmuka membulat dengan dukungan **Dark Mode** yang persisten.
- **Tab Navigation**: Pindah antar tab (Semua, Gambar, Berita) tanpa me-reload halaman.
- **Search History**: Menyimpan riwayat pencarian terakhir menggunakan `localStorage`.

## 🛠️ Teknologi yang Digunakan
- **Backend**: Laravel 13 (PHP 8.3+)
- **Frontend**: Blade, Tailwind CSS v4, Vanilla JavaScript
- **Build Tool**: Vite
- **API**: Tavily Search API

## 🚀 Cara Menjalankan Secara Lokal
1. `git clone https://github.com/Re1He4rt/pixle.git`
2. `cd pixle`
3. `composer install` & `npm install`
4. `cp .env.example .env`
5. Tambahkan `TAVILY_API_KEY` di file `.env` (Dapatkan gratis di [tavily.com](https://tavily.com/)).
6. `php artisan key:generate`
7. Jalankan `php artisan serve` dan `npm run dev` di dua terminal berbeda.
8. Buka `http://127.0.0.1:8000`.

---
*Dibuat oleh [Re1He4rt](https://github.com/Re1He4rt) sebagai proyek portofolio.*
