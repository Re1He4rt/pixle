@extends('layouts.app')

@section('content')
<div class="min-h-screen font-sans">

    <!-- Header / Search Bar -->
    <header class="sticky top-0 bg-[#fef7ff] dark:bg-[#1d1b20] z-10 py-6 px-4 border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">
        <form id="search-form" class="max-w-3xl mx-auto flex items-center gap-4">
            <a href="/" class="text-3xl font-bold text-[#6750a4] dark:text-[#d0bcff] hidden sm:block">Pixel.</a>

            <div class="flex-1 relative">
                <input type="search" name="q" id="search-input" placeholder="Cari sesuatu..." autocomplete="off"
                    class="w-full bg-[#eaddff] dark:bg-[#4f378b] text-[#21005d] dark:text-[#eaddff] px-6 py-3 rounded-full outline-none focus:ring-2 focus:ring-[#6750a4] dark:focus:ring-[#d0bcff] transition-all placeholder-[#21005d]/50 dark:placeholder-[#eaddff]/50">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#6750a4] dark:bg-[#d0bcff] text-white dark:text-[#21005d] p-2 rounded-full hover:bg-[#4f378b] dark:hover:bg-[#eaddff] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <!-- Tombol Dark Mode -->
            <button type="button" id="theme-toggle" class="p-3 rounded-full bg-gray-200 dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors shrink-0">
                <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            </button>
        </form>
    </header>

    <!-- Navigasi Tab -->
    <nav class="max-w-3xl mx-auto px-4 mt-2">
        <ul class="flex gap-2 border-b border-gray-200 dark:border-gray-800">
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
    <div id="history-container" class="max-w-3xl mx-auto px-4 mt-6 hidden">
        <p class="text-sm font-medium text-[#49454f] dark:text-[#cac4d0] mb-3">Pencarian Terakhir</p>
        <div id="history-list" class="flex flex-wrap gap-2">
            <!-- Tombol riwayat akan muncul di sini -->
        </div>
    </div>

    <!-- Area Hasil Pencarian -->
    <main id="results-container" class="max-w-3xl mx-auto px-4 py-8 pb-20">
        <!-- Hasil akan dimasukkan ke sini oleh JavaScript -->
    </main>

</div>
@endsection

@push('scripts')
<script>
  const resultsContainer = document.getElementById('results-container');
  const searchInput = document.getElementById('search-input');
  const searchForm = document.getElementById('search-form');

  let currentResults = [];
  let currentImages = [];
  let currentQuery = '';

  searchForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    await jalankanPencarian();
  });

  async function jalankanPencarian() {
    const query = searchInput.value.trim();
    if (!query) return;

    currentQuery = query;
     simpanRiwayat(query);
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

          // Reset tab UI ke "Semua"
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

  async function pindahTab(namaTab) {
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
  }

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
            <h3 class="text-xl font-medium text-[#1d1b20] dark:text-[#e6e0e9] mb-2">Tidak ada hasil ditemukan</h3>
            <p class="text-[#49454f] dark:text-[#cac4d0]">Coba gunakan kata kunci lain atau periksa ejaanmu.</p>
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

  window.pindahTab = pindahTab;

    // --- Logika Dark Mode (Langsung Eksekusi) ---
  const themeToggleBtn = document.getElementById('theme-toggle');
  const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
  const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

  if (themeToggleBtn) {
      // Atur ikon awal
      if (document.documentElement.classList.contains('dark')) {
          themeToggleLightIcon.classList.remove('hidden');
      } else {
          themeToggleDarkIcon.classList.remove('hidden');
      }

      // Pasang event klik
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

  const historyContainer = document.getElementById('history-container');
  const historyList = document.getElementById('history-list');

  function simpanRiwayat(query) {
      let history = JSON.parse(localStorage.getItem('search_history')) || [];

      // Hapus jika query sudah ada (agar tidak duplikat)
      history = history.filter(item => item.toLowerCase() !== query.toLowerCase());

      // Tambahkan query baru ke paling depan
      history.unshift(query);

      // Batasi maksimal 5 riwayat
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

      // Buat tombol (chip) untuk setiap riwayat
      historyList.innerHTML = history.map(item => `
          <button onclick="cariDariRiwayat('${item}')" class="px-4 py-1.5 bg-white dark:bg-[#25232a] border border-gray-200 dark:border-gray-700 rounded-full text-sm text-[#1d1b20] dark:text-[#e6e0e9] hover:bg-[#eaddff] dark:hover:bg-[#4f378b] transition-colors">
              ${item}
          </button>
      `).join('');
  }

  // Fungsi jika tombol riwayat diklik
  window.cariDariRiwayat = function(query) {
      searchInput.value = query;
      jalankanPencarian();
  };

  // Tampilkan riwayat saat halaman pertama kali dimuat
  tampilkanRiwayat();
</script>
@endpush
