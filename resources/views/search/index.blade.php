@extends('layouts.app')

@section('content')
<div id="app-wrapper" class="min-h-screen font-sans flex flex-col transition-all duration-500 ease-in-out justify-center relative overflow-hidden bg-gray-50 dark:bg-[#1d1b20]">

    <!-- Background Gambar -->
    <div class="absolute inset-0 z-0 opacity-10 dark:opacity-5 pointer-events-none">
        <img src="https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?q=80&w=2564&auto=format&fit=crop" alt="bg" class="w-full h-full object-cover">
    </div>

    <!-- Top Right Links (Gmail, Images, Profil) -->
    <div class="absolute top-4 right-6 z-20 flex items-center gap-4 text-sm text-[#1d1b20] dark:text-[#e6e0e9]">
        <a href="#" class="hover:underline hidden sm:block">Gmail</a>
        <a href="#" class="hover:underline hidden sm:block">Images</a>
        <div class="w-8 h-8 rounded-full bg-[#6750a4] text-white flex items-center justify-center font-bold cursor-pointer">R</div>
    </div>

    <!-- Container Utama untuk Logo & Search Bar -->
    <div id="search-header-container" class="w-full z-10 transition-all duration-500 flex flex-col items-center">

        <div class="w-full max-w-3xl px-4 flex flex-col items-center">

            <!-- Logo -->
            <a href="#" onclick="setToHomeLayout(); return false;" id="logo-container" class="text-6xl font-bold text-[#6750a4] dark:text-[#d0bcff] mb-8 transition-all duration-500 block text-center">
                Pixel.
            </a>

            <!-- Search Bar -->
            <form id="search-form" class="w-full relative group">
                <div class="flex items-center w-full bg-white dark:bg-[#25232a] border border-gray-200 dark:border-gray-700 px-4 py-3 rounded-full shadow-sm hover:shadow-md focus-within:shadow-lg transition-all">

                    <!-- Ikon Plus -->
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>

                    <!-- INPUT PENCARIAN -->
                    <input type="search" name="q" id="search-input" placeholder="Ask Pixel" autocomplete="off"
                        class="flex-1 bg-transparent text-[#1d1b20] dark:text-[#e6e0e9] outline-none text-lg placeholder-gray-400">

                    <!-- Ikon Mic & Lens (Hiasan) -->
                    <svg class="w-5 h-5 text-blue-500 mx-2 cursor-pointer" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7 4a3 3 0 016 0v4a3 3 0 11-6 0V4zm4 10.93A7.001 7.001 0 0017 8a1 1 0 10-2 0A5 5 0 015 8a1 1 0 00-2 0 7.001 7.001 0 006 6.93V17H6a1 1 0 100 2h8a1 1 0 100-2h-3v-2.07z" clip-rule="evenodd"></path></svg>
                    <svg class="w-5 h-5 text-yellow-500 mx-2 cursor-pointer" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>

                    <!-- Tombol Search -->
                    <button type="submit" class="bg-transparent text-[#6750a4] dark:text-[#d0bcff] p-1 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors ml-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Dropdown Autocomplete -->
                <div id="autocomplete-dropdown" class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-[#25232a] border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl z-50 hidden overflow-hidden">
                    <ul id="autocomplete-list" class="py-2"></ul>
                </div>
            </form>

            <!-- Shortcut Icons -->
            <div id="shortcuts-container" class="flex flex-wrap justify-center gap-6 mt-10 max-w-xl transition-opacity duration-300">
                <!-- YouTube -->
                <div onclick="cariCepat('YouTube')" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm group-hover:bg-gray-100 dark:group-hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition-transform group-hover:scale-110">
                        <span class="text-red-500 font-bold text-xl">Y</span>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-300">YouTube</span>
                </div>
                <!-- Facebook -->
                <div onclick="cariCepat('Facebook')" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm group-hover:bg-gray-100 dark:group-hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition-transform group-hover:scale-110">
                        <span class="text-blue-600 font-bold text-xl">F</span>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-300">Facebook</span>
                </div>
                <!-- Instagram -->
                <div onclick="cariCepat('Instagram')" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm group-hover:bg-gray-100 dark:group-hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition-transform group-hover:scale-110">
                        <span class="text-pink-500 font-bold text-xl">I</span>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-300">Instagram</span>
                </div>
                <!-- GitHub -->
                <div onclick="bukaLink('https://github.com/Re1He4rt')" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm group-hover:bg-gray-100 dark:group-hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition-transform group-hover:scale-110">
                        <span class="text-gray-800 dark:text-white font-bold text-xl">G</span>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-300">GitHub</span>
                </div>
                <!-- Wikipedia -->
                <div onclick="bukaLink('https://id.wikipedia.org')" class="flex flex-col items-center gap-2 cursor-pointer group">
                    <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-sm group-hover:bg-gray-100 dark:group-hover:bg-gray-700 border border-gray-200 dark:border-gray-700 transition-transform group-hover:scale-110">
                        <span class="text-black dark:text-white font-serif font-bold text-xl">W</span>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-300">Wikipedia</span>
                </div>
            </div>

            <!-- Tombol Dark Mode -->
            <button type="button" id="theme-toggle" class="mt-8 p-3 rounded-full bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors">
                <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>

        </div>
    </div>

    <!-- Container untuk Navigasi Tab dan Hasil (Disembunyikan saat Home) -->
    <div id="results-section" class="w-full hidden z-10 flex-col items-center">
        <!-- Navigasi Tab -->
        <nav class="w-full max-w-3xl mx-auto px-4 mt-6 border-b border-gray-200 dark:border-gray-800">
            <ul class="flex gap-2">
                <li>
                    <button onclick="pindahTab('semua')" id="tab-semua" class="tab-btn px-4 py-2 text-[#6750a4] dark:text-[#d0bcff] border-b-2 border-[#6750a4] dark:border-[#d0bcff] font-medium transition-colors">Semua</button>
                </li>
                <li>
                    <button onclick="pindahTab('gambar')" id="tab-gambar" class="tab-btn px-4 py-2 text-[#49454f] dark:text-[#cac4d0] border-b-2 border-transparent hover:text-[#6750a4] dark:hover:text-[#d0bcff] font-medium transition-colors">Gambar</button>
                </li>
                <li>
                    <button onclick="pindahTab('berita')" id="tab-berita" class="tab-btn px-4 py-2 text-[#49454f] dark:text-[#cac4d0] border-b-2 border-transparent hover:text-[#6750a4] dark:hover:text-[#d0bcff] font-medium transition-colors">Berita</button>
                </li>
            </ul>
        </nav>

        <!-- Wadah Riwayat Pencarian -->
        <div id="history-container" class="w-full max-w-3xl mx-auto px-4 mt-6 hidden">
            <p class="text-sm font-medium text-[#49454f] dark:text-[#cac4d0] mb-3">Pencarian Terakhir</p>
            <div id="history-list" class="flex flex-wrap gap-2"></div>
        </div>

        <!-- Area Hasil Pencarian -->
        <main id="results-container" class="w-full max-w-3xl mx-auto px-4 py-8 pb-20"></main>
    </div>

    <!-- Tombol Scroll to Top -->
    <button id="scroll-top-btn" class="fixed bottom-8 right-8 p-3 bg-[#6750a4] dark:bg-[#d0bcff] text-white dark:text-[#21005d] rounded-full shadow-lg opacity-0 pointer-events-none transition-all duration-300 hover:scale-110 z-50">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
    </button>

</div>
@endsection

@push('scripts')
<script>
  // --- 1. DEKLARASI VARIABEL GLOBAL (Harus di paling atas) ---
  const resultsContainer = document.getElementById('results-container');
  const searchInput = document.getElementById('search-input');
  const searchForm = document.getElementById('search-form');
  const autocompleteDropdown = document.getElementById('autocomplete-dropdown');
  const autocompleteList = document.getElementById('autocomplete-list');
  const appWrapper = document.getElementById('app-wrapper');
  const searchHeaderContainer = document.getElementById('search-header-container');
  const resultsSection = document.getElementById('results-section');
  const logoContainer = document.getElementById('logo-container');
  const shortcutsContainer = document.getElementById('shortcuts-container');
  const themeToggleBtn = document.getElementById('theme-toggle');
  const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
  const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
  const historyContainer = document.getElementById('history-container');
  const historyList = document.getElementById('history-list');
  const scrollTopBtn = document.getElementById('scroll-top-btn');

  let currentResults = [];
  let currentImages = [];
  let currentQuery = '';

  // --- 2. FUNGSI GLOBAL UNTUK HTML ONCLICK ---
  window.cariCepat = function(keyword) {
      searchInput.value = keyword;
      jalankanPencarian();
  };

  window.bukaLink = function(url) {
      window.open(url, '_blank');
  };

  window.cariDariRiwayat = function(query) {
      searchInput.value = query;
      jalankanPencarian();
  };

  window.pindahTab = async function(namaTab) {
    if (currentResults.length === 0 && currentImages.length === 0) return;

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('text-[#6750a4]', 'dark:text-[#d0bcff]', 'border-[#6750a4]', 'dark:border-[#d0bcff]');
        btn.classList.add('text-[#49454f]', 'dark:text-[#cac4d0]', 'border-transparent');
    });

    const activeBtn = document.getElementById(`tab-${namaTab}`);
    activeBtn.classList.remove('text-[#49454f]', 'dark:text-[#cac4d0]', 'border-transparent');
    activeBtn.classList.add('text-[#6750a4]', 'dark:text-[#d0bcff]', 'border-[#6750a4]', 'dark:border-[#d0bcff]');

    await window.pixelTransition({
      update: () => {
        renderTabAktif(namaTab);
      }
    });
  };

  // --- 3. LOGIKA LAYOUT (HOME vs RESULTS) ---
  function setToResultsLayout() {
      appWrapper.classList.remove('justify-center');
      appWrapper.classList.add('justify-start');
      searchHeaderContainer.classList.remove('mt-0', 'mb-0');
      searchHeaderContainer.classList.add('py-4', 'border-b', 'border-gray-200', 'dark:border-gray-800', 'bg-[#fef7ff]', 'dark:bg-[#1d1b20]', 'sticky', 'top-0', 'z-50');
      logoContainer.classList.remove('text-6xl', 'mb-8');
      logoContainer.classList.add('text-3xl', 'mb-0', 'hidden', 'sm:block');
      shortcutsContainer.classList.add('hidden');
      resultsSection.classList.remove('hidden');
      resultsSection.classList.add('flex');
  }

  window.setToHomeLayout = function() {
      appWrapper.classList.remove('justify-start');
      appWrapper.classList.add('justify-center');
      searchHeaderContainer.classList.remove('py-4', 'border-b', 'border-gray-200', 'dark:border-gray-800', 'bg-[#fef7ff]', 'dark:bg-[#1d1b20]', 'sticky', 'top-0', 'z-50');
      logoContainer.classList.remove('text-3xl', 'mb-0', 'hidden', 'sm:block');
      logoContainer.classList.add('text-6xl', 'mb-8');
      shortcutsContainer.classList.remove('hidden');
      resultsSection.classList.add('hidden');
      resultsSection.classList.remove('flex');
      searchInput.value = '';
      resultsContainer.innerHTML = '';
      window.history.pushState({}, '', '/');
  }

  // --- 4. LOGIKA PENCARIAN ---
  searchForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await jalankanPencarian();
  });

  async function jalankanPencarian() {
    const query = searchInput.value.trim();
    if (!query) return;

    currentQuery = query;
    simpanRiwayat(query);
    setToResultsLayout();
    window.history.pushState({}, '', `?q=${encodeURIComponent(query)}`);

    if (typeof window.pixelTransition !== 'function') {
        alert("Animasi belum siap. Pastikan 'npm run dev' berjalan!");
        return;
    }

    await window.pixelTransition({
      update: () => {
        resultsContainer.innerHTML = '<div class="animate-pulse flex flex-col gap-4"><div class="h-6 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div><div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-full"></div></div>';
      },
      waitFor: async () => {
        try {
          const res = await fetch(`/api/search?q=${encodeURIComponent(query)}`, {
            headers: { 'Accept': 'application/json' }
          });

          if (!res.ok) throw new Error('Gagal memuat hasil');
          const data = await res.json();

          currentResults = data.results || [];
          currentImages = data.images || [];

          renderTabAktif('semua');

          document.querySelectorAll('.tab-btn').forEach(btn => {
              btn.classList.remove('text-[#6750a4]', 'dark:text-[#d0bcff]', 'border-[#6750a4]', 'dark:border-[#d0bcff]');
              btn.classList.add('text-[#49454f]', 'dark:text-[#cac4d0]', 'border-transparent');
          });
          const tabSemua = document.getElementById('tab-semua');
          tabSemua.classList.remove('text-[#49454f]', 'dark:text-[#cac4d0]', 'border-transparent');
          tabSemua.classList.add('text-[#6750a4]', 'dark:text-[#d0bcff]', 'border-[#6750a4]', 'dark:border-[#d0bcff]');

        } catch (error) {
          resultsContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center mt-20 text-center">
              <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <h3 class="text-xl font-medium text-[#1d1b20] dark:text-[#e6e0e9] mb-2">Ups, terjadi kesalahan</h3>
              <p class="text-[#49454f] dark:text-[#cac4d0] mb-6 max-w-md">${error.message}. Pastikan koneksi internetmu stabil atau coba beberapa saat lagi.</p>
              <button onclick="jalankanPencarian()" class="px-6 py-2 bg-[#6750a4] dark:bg-[#d0bcff] text-white dark:text-[#21005d] rounded-full font-medium hover:bg-[#4f378b] dark:hover:bg-[#eaddff] transition-colors">
                Coba Lagi
              </button>
            </div>
          `;
        }
      }
    });
  }

  // --- 5. LOGIKA RENDER HASIL PER TAB ---
  function renderTabAktif(namaTab) {
    if (namaTab === 'semua') {
       if (currentResults.length === 0) {
        resultsContainer.innerHTML = `
          <div class="flex flex-col items-center justify-center mt-20 text-center">
            <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <h3 class="text-xl font-medium text-[#1d1b20] dark:text-[#e6e0e9] mb-2">Tidak ada hasil ditemukan</h3>
            <p class="text-[#49454f] dark:text-[#cac4d0]">Coba gunakan kata kunci lain atau periksa ejaanmu.</p>
          </div>
        `;
        return;
      }

      resultsContainer.innerHTML = currentResults.map(r => {
        const snippet = r.snippet.length > 200 ? r.snippet.substring(0, 200) + '...' : r.snippet;
        let domain = ''; try { domain = new URL(r.url).hostname; } catch (e) { domain = r.url; }
        return `
          <article class="mb-8 group p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 rounded-xl transition-colors">
            <div class="flex items-center gap-2 mb-1">
              <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-500 dark:text-gray-300">${domain.charAt(0).toUpperCase()}</div>
              <span class="text-sm text-[#49454f] dark:text-[#cac4d0]">${domain}</span>
            </div>
            <a href="${r.url}" target="_blank" rel="noopener" class="block group-hover:underline">
              <h2 class="text-xl text-[#6750a4] dark:text-[#d0bcff] font-medium mb-1 leading-snug">${r.title}</h2>
            </a>
            <p class="text-[#1d1b20] dark:text-[#e6e0e9] text-sm leading-relaxed">${snippet}</p>
          </article>
        `;
      }).join('');
    }
    else if (namaTab === 'gambar') {
       if (currentImages.length === 0) {
        resultsContainer.innerHTML = `
          <div class="flex flex-col items-center justify-center mt-20 text-center">
            <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <h3 class="text-xl font-medium text-[#1d1b20] dark:text-[#e6e0e9] mb-2">Tidak ada gambar ditemukan</h3>
            <p class="text-[#49454f] dark:text-[#cac4d0]">Coba gunakan kata kunci lain.</p>
          </div>
        `;
        return;
      }

      resultsContainer.innerHTML = `
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            ${currentImages.map((imgUrl, index) => `
                <div class="bg-gray-100 dark:bg-gray-800 rounded-xl overflow-hidden aspect-square flex items-center justify-center relative group cursor-pointer border border-gray-200 dark:border-gray-700">
                    <img src="${imgUrl}" alt="Hasil Pencarian ${index + 1}" class="w-full h-full object-cover" loading="lazy">
                </div>
            `).join('')}
        </div>
      `;
    }
    else if (namaTab === 'berita') {
       if (currentResults.length === 0) {
        resultsContainer.innerHTML = `
          <div class="flex flex-col items-center justify-center mt-20 text-center">
            <svg class="w-24 h-24 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <h3 class="text-xl font-medium text-[#1d1b20] dark:text-[#e6e0e9] mb-2">Tidak ada berita ditemukan</h3>
            <p class="text-[#49454f] dark:text-[#cac4d0]">Coba gunakan kata kunci lain.</p>
          </div>
        `;
        return;
      }

      resultsContainer.innerHTML = currentResults.map(r => {
        let domain = ''; try { domain = new URL(r.url).hostname; } catch (e) { domain = r.url; }
        return `
          <article class="mb-4 p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-md dark:hover:shadow-lg dark:hover:shadow-black/30 transition-shadow cursor-pointer bg-white dark:bg-[#25232a]">
              <h2 class="text-lg text-[#6750a4] dark:text-[#d0bcff] font-medium">${r.title}</h2>
            <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">${r.snippet.substring(0, 100)}...</p>
            <span class="text-xs text-gray-400 dark:text-gray-500 mt-2 block">Baru saja • ${domain}</span>
          </article>
        `;
      }).join('');
    }
  }

  // --- 6. LOGIKA DARK MODE ---
  if (themeToggleBtn) {
      if (document.documentElement.classList.contains('dark')) {
          themeToggleLightIcon.classList.remove('hidden');
      } else {
          themeToggleDarkIcon.classList.remove('hidden');
      }

      themeToggleBtn.addEventListener('click', function() {
          themeToggleDarkIcon.classList.toggle('hidden');
          themeToggleLightIcon.classList.toggle('hidden');

          if (document.documentElement.classList.contains('dark')) {
              document.documentElement.classList.remove('dark');
              localStorage.setItem('theme', 'light');
          } else {
              document.documentElement.classList.add('dark');
              localStorage.setItem('theme', 'dark');
          }
      });
  }

  // --- 7. LOGIKA RIWAYAT ---
  function simpanRiwayat(query) {
      let history = JSON.parse(localStorage.getItem('search_history')) || [];
      history = history.filter(item => item.toLowerCase() !== query.toLowerCase());
      history.unshift(query);
      if (history.length > 5) history.pop();
      localStorage.setItem('search_history', JSON.stringify(history));
      tampilkanRiwayat();
  }

  function tampilkanRiwayat() {
      const history = JSON.parse(localStorage.getItem('search_history')) || [];
      if (history.length === 0) {
          historyContainer.classList.add('hidden');
          return;
      }
      historyContainer.classList.remove('hidden');
      historyList.innerHTML = history.map(item => `
          <button onclick="cariDariRiwayat('${item}')" class="px-4 py-1.5 bg-white dark:bg-[#25232a] border border-gray-200 dark:border-gray-700 rounded-full text-sm text-[#1d1b20] dark:text-[#e6e0e9] hover:bg-[#eaddff] dark:hover:bg-[#4f378b] transition-colors">
              ${item}
          </button>
      `).join('');
  }

  tampilkanRiwayat();

  // --- 8. LOGIKA AUTOCOMPLETE ---
  const suggestions = ['Laravel 13', 'PHP', 'JavaScript', 'Tailwind CSS', 'Google Pixel', 'YouTube', 'Instagram', 'Elon Musk', 'Wikipedia', 'Tavily API'];

  searchInput.addEventListener('input', function() {
      const value = this.value.toLowerCase().trim();
      autocompleteList.innerHTML = '';

      if (!value) {
          autocompleteDropdown.classList.add('hidden');
          return;
      }

      const filtered = suggestions.filter(item => item.toLowerCase().includes(value));

      if (filtered.length > 0) {
          autocompleteDropdown.classList.remove('hidden');
          filtered.forEach(item => {
              const li = document.createElement('li');
              li.className = 'px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer text-[#1d1b20] dark:text-[#e6e0e9] flex items-center gap-3 transition-colors';
              li.innerHTML = `<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg> ${item}`;
              li.addEventListener('click', () => {
                  searchInput.value = item;
                  autocompleteDropdown.classList.add('hidden');
                  jalankanPencarian();
              });
              autocompleteList.appendChild(li);
          });
      } else {
          autocompleteDropdown.classList.add('hidden');
      }
  });

  document.addEventListener('click', function(e) {
      if (!searchForm.contains(e.target)) {
          autocompleteDropdown.classList.add('hidden');
      }
  });

  // --- 9. LOGIKA SCROLL TO TOP ---
  window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
          scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none');
          scrollTopBtn.classList.add('opacity-100', 'pointer-events-auto');
      } else {
          scrollTopBtn.classList.add('opacity-0', 'pointer-events-none');
          scrollTopBtn.classList.remove('opacity-100', 'pointer-events-auto');
      }
  });

  scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
@endpush
