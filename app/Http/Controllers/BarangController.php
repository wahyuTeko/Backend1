<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class BarangController extends Controller
{
    public function __construct()
    {
        $this->Middleware('jwt.auth', ['except' => ['index']]);
    }

    public function index()
    {
        return response()->json($barang::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => '|required|',
            'price' => 'required|integer',
        ]);

        $barang = Barang::create($request->all());
        return response()->json($barang, 201);
    }
    
    public function show($id)
    {
        $barang = Barang::find($id);
        if ($barang) {
            return response()->json(['massage' => 'barang not found'], 404);
        }
        return response()->json($barang);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'sometimes|required',
            'description' => 'sometimes|required',
            'price' => 'sometimes|required|integer',
        ]);

        $barang = barang::find($id);
        if ($barang) {
            return response()->json(['massage' => 'barang not found'], 404);
        }

        $barang->update($request->all());
        return response()->json($barang);

    }
    
    public function destroy($id)
    {
        $barang = barang::find($id);
        if ($barang) {
            return response()->json(['massage' => 'barang not found'], 404);
        }

        $barang->delete();
        return response()->json(['massage' => 'barang delete']);
    }
}
