<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return response()->json(Barang::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_barang' => 'required',
            'kategori' => 'required',
            'stock' => 'required|integer',
            'deskripsi' => 'required',
            'harga' => 'required|integer',
            'foto_barang' => 'nullable|string'
        ]);
    
        $barang = Barang::create([
            'nama_barang' => $request->input('nama_barang'),
            'kategori' => $request->input('kategori'),
            'stock' => $request->input('stock'),
            'deskripsi' => $request->input('deskripsi'),
            'harga' => $request->input('harga'),
            'foto_barang' => $request->input('foto_barang')
        ]);
    
        return response()->json($barang, 201);
    }

    public function show($id)
    {
        $barang = barang::find($id);
        if (!$barang) {
            return response()->json(['massage' => 'Baranng not found'], 404);
        }
        return response()->json($barang);
    }

    public function update(request $request, $id)
    {
        $this->validate($request, [
            'nama_barang' => 'required',
            'kategori' => 'required',
            'stock' => 'required|integer',
            'deskripsi' => 'required',
            'harga' => 'required|integer',
            'foto_barang' => 'nullable|string'
        ]);

        $barang = Barang::find($id);
        if ($barang) {
            return response()->json(['massage' => 'Barang not found'], 404);
        }

        $barang->update($request->all());
        return response()->json($barang);
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['massage' => 'Barang not found'], 404);
        }

        $barang->delete();
        return response()->json(['massage' => 'barang deleted']);
    }
        
}
