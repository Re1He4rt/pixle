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
            return response()->json(['results' => [], 'images' => []]);
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.tavily.api_key'),
            'Content-Type' => 'application/json',
        ])->post('https://api.tavily.com/search', [
            'query' => $query,
            'search_depth' => 'basic',
            'max_results' => 5,
            'include_images' => true, // <-- TAMBAHKAN INI
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data dari API'], 500);
        }

        $tavilyResults = $response->json('results') ?? [];
        $tavilyImages = $response->json('images') ?? []; // <-- AMBIL GAMBAR

        $formattedResults = array_map(function($item) {
            return [
                'title' => $item['title'] ?? 'Tanpa Judul',
                'url' => $item['url'] ?? '#',
                'snippet' => $item['content'] ?? '',
            ];
        }, $tavilyResults);

        return response()->json([
            'results' => $formattedResults,
            'images' => $tavilyImages, // <-- KIRIM KE FRONTEND
        ]);
    }
}
