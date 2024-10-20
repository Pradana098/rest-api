<?php
namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        return Buku::with('kategori')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string', // Nama buku tidak boleh kosong
            'penulis' => 'required|string',
            'harga' => 'required|numeric|min:1000', // Harga minimal Rp 1.000
            'kategori_id' => 'required|exists:kategoris,id',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $buku = Buku::create($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Buku berhasil ditambahkan',
            'data' => $buku
        ], 201);
    }

    public function show($id)
    {
        return Buku::with('kategori')->find($id);
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->all());
        return response()->json($buku, 200);
    }

    public function destroy($id)
    {
        Buku::destroy($id);
        return response()->json(null, 204);
    }
    public function search(Request $request)
    {
        $query = Buku::query();

        // Pencarian berdasarkan judul
        if ($request->has('judul')) {
            $query->where('judul', 'LIKE', '%' . $request->judul . '%');
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Pengurutan
        $sort = $request->input('sort', 'judul');
        $direction = $request->input('direction', 'asc');
        $query->orderBy($sort, $direction);

        // Pagination untuk performa
        $perPage = $request->input('per_page', 10);
        $books = $query->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'data' => $books,
            'meta' => [
                'total' => $books->total(),
                'per_page' => $books->perPage(),
                'current_page' => $books->currentPage(),
                'last_page' => $books->lastPage()
            ]
        ]);
    }
}