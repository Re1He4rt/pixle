@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fef7ff] text-[#1d1b20] font-sans">

    <!-- Header / Search Bar -->
    <header class="sticky top-0 bg-[#fef7ff] z-10 py-6 px-4 border-b border-gray-200">
        <form id="search-form" class="max-w-3xl mx-auto flex items-center gap-4">
            <a href="/" class="text-3xl font-bold text-[#6750a4] hidden sm:block">Pixel.</a>

            <div class="flex-1 relative">
                <input type="search" name="q" id="search-input" placeholder="Cari sesuatu..." autocomplete="off"
                    class="w-full bg-[#eaddff] text-[#21005d] px-6 py-3 rounded-full outline-none focus:ring-2 focus:ring-[#6750a4] transition-all placeholder-[#21005d]/50">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-[#6750a4] text-white p-2 rounded-full hover:bg-[#4f378a] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </header>

     <!-- TAMBAHKAN NAVIGASI TAB DI SINI -->
    <nav class="max-w-3xl mx-auto px-4 mt-2">
        <ul class="flex gap-2 border-b border-gray-200">
            <li>
                <button onclick="pindahTab('semua')" id="tab-semua" class="tab-btn px-4 py-2 text-[#6750a4] border-b-2 border-[#6750a4] font-medium transition-colors">Semua</button>
            </li>
            <li>
                <button onclick="pindahTab('gambar')" id="tab-gambar" class="tab-btn px-4 py-2 text-[#49454f] border-b-2 border-transparent hover:text-[#6750a4] font-medium transition-colors">Gambar</button>
            </li>
            <li>
                <button onclick="pindahTab('berita')" id="tab-berita" class="tab-btn px-4 py-2 text-[#49454f] border-b-2 border-transparent hover:text-[#6750a4] font-medium transition-colors">Berita</button>
            </li>
        </ul>
    </nav>

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
  let currentQuery = '';

  // --- 1. Tangkap event submit dari form ---
  searchForm.addEventListener('submit', async (e) => {
    e.preventDefault(); // Mencegah reload halaman (SANGAT PENTING)
    await jalankanPencarian();
  });

  async function jalankanPencarian() {
    const query = searchInput.value.trim();
    if (!query) return;

    currentQuery = query;
    window.history.pushState({}, '', `?q=${encodeURIComponent(query)}`);

    if (typeof window.pixelTransition !== 'function') {
        alert("Animasi belum siap. Pastikan 'npm run dev' berjalan!");
        return;
    }

    await window.pixelTransition({
      update: () => {
        resultsContainer.innerHTML = '<div class="animate-pulse flex flex-col gap-4"><div class="h-6 bg-gray-200 rounded w-3/4"></div><div class="h-4 bg-gray-200 rounded w-full"></div></div>';
      },
      waitFor: async () => {
        try {
          const res = await fetch(`/api/search?q=${encodeURIComponent(query)}`, {
            headers: { 'Accept': 'application/json' }
          });

          if (!res.ok) throw new Error('Gagal memuat hasil');
          const data = await res.json();

          currentResults = data.results || [];

          // Render tab yang sedang aktif (default: semua)
          renderTabAktif('semua');

          // Reset tab UI ke "Semua"
          document.querySelectorAll('.tab-btn').forEach(btn => {
              btn.classList.remove('text-[#6750a4]', 'border-[#6750a4]');
              btn.classList.add('text-[#49454f]', 'border-transparent');
          });
          document.getElementById('tab-semua').classList.remove('text-[#49454f]', 'border-transparent');
          document.getElementById('tab-semua').classList.add('text-[#6750a4]', 'border-[#6750a4]');

        } catch (error) {
          resultsContainer.innerHTML = `<p class="text-red-500 p-4">Terjadi kesalahan: ${error.message}</p>`;
        }
      }
    });
  }

  // --- 2. Fungsi Pindah Tab ---
  async function pindahTab(namaTab) {
    if (currentResults.length === 0) return;

    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('text-[#6750a4]', 'border-[#6750a4]');
        btn.classList.add('text-[#49454f]', 'border-transparent');
    });
    const activeBtn = document.getElementById(`tab-${namaTab}`);
    activeBtn.classList.remove('text-[#49454f]', 'border-transparent');
    activeBtn.classList.add('text-[#6750a4]', 'border-[#6750a4]');

    await window.pixelTransition({
      update: () => {
        renderTabAktif(namaTab);
      }
    });
  }

  // --- 3. Fungsi Render Konten ---
  function renderTabAktif(namaTab) {
    if (currentResults.length === 0) {
      resultsContainer.innerHTML = '<p class="text-gray-500 text-center mt-10">Tidak ada hasil.</p>';
      return;
    }

    if (namaTab === 'semua') {
      resultsContainer.innerHTML = currentResults.map(r => {
        const snippet = r.snippet.length > 200 ? r.snippet.substring(0, 200) + '...' : r.snippet;
        let domain = ''; try { domain = new URL(r.url).hostname; } catch (e) { domain = r.url; }
        return `
          <article class="mb-8 group p-4 hover:bg-gray-50 rounded-xl transition-colors">
            <div class="flex items-center gap-2 mb-1">
              <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-500">${domain.charAt(0).toUpperCase()}</div>
              <span class="text-sm text-[#49454f]">${domain}</span>
            </div>
            <a href="${r.url}" target="_blank" rel="noopener" class="block group-hover:underline">
              <h2 class="text-xl text-[#6750a4] font-medium mb-1 leading-snug">${r.title}</h2>
            </a>
            <p class="text-[#1d1b20] text-sm leading-relaxed">${snippet}</p>
          </article>
        `;
      }).join('');
    }
    else if (namaTab === 'gambar') {
      resultsContainer.innerHTML = `
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            ${currentResults.map((r) => `
                <div class="bg-gray-100 rounded-xl overflow-hidden aspect-video flex items-center justify-center relative group cursor-pointer border border-gray-200">
                    <span class="text-gray-400 text-4xl">🖼️</span>
                    <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-2 text-xs truncate opacity-0 group-hover:opacity-100 transition-opacity">
                        ${r.title}
                    </div>
                </div>
            `).join('')}
        </div>
      `;
    }
    else if (namaTab === 'berita') {
      resultsContainer.innerHTML = currentResults.map(r => `
        <article class="mb-4 p-4 border border-gray-200 rounded-xl hover:shadow-md transition-shadow cursor-pointer">
            <h2 class="text-lg text-[#6750a4] font-medium">${r.title}</h2>
          <p class="text-gray-600 text-sm mt-1">${r.snippet.substring(0, 100)}...</p>
          <span class="text-xs text-gray-400 mt-2 block">Baru saja • ${new URL(r.url).hostname}</span>
        </article>
      `).join('');
    }
  }

  // Daftarkan ke window agar tombol tab di HTML bisa memanggilnya
  window.pindahTab = pindahTab;
</script>
@endpush
