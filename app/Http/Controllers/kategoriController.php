<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;


class kategoriController extends Controller
{
    /**

     */
    public function index()
    {
        return Kategori::all();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['nama_kategori' => 'required']);
        $kategori = Kategori::create($request->all());
        return response()->json($kategori, 201);

    }

   
}
