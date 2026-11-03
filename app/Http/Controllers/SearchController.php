<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function index()
    {
        // Mengarahkan ke file resources/views/search/index.blade.php
        return view('search.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json(['results' => []]);
        }

        // 1. Panggil API Tavily menggunakan HTTP Client Laravel
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.tavily.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.tavily.com/search', [
            'query' => $query,
            'search_depth' => 'basic',
            'max_results' => 5,
        ]);

        // 2. Cek jika API gagal merespons
        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data dari API'], 500);
        }

        // 3. Ambil data hasil dari Tavily
        $tavilyResults = $response->json('results') ?? [];

        // 4. Format ulang data agar sesuai dengan yang diharapkan oleh Frontend (JavaScript)
        $formattedResults = array_map(function($item) {
            return [
                'title' => $item['title'] ?? 'Tanpa Judul',
                'url' => $item['url'] ?? '#',
                // Tavily menggunakan 'content', frontend kita mengharapkan 'snippet'
                'snippet' => $item['content'] ?? '',
            ];
        }, $tavilyResults);

        // 5. Kembalikan sebagai JSON
        return response()->json([
            'results' => $formattedResults
        ]);
    }
}
