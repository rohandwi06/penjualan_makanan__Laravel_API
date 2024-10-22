<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Item::select('id', 'nama', 'harga', 'image')->get();

        return response(['data' => $item]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|max:225',
            'harga' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png',
        ]);

        // Inisialisasi array untuk data yang akan disimpan
        $data = $request->only(['nama', 'harga']); // Ambil input yang lain dulu

        // Jika ada file yang diupload, proses dan simpan nama filenya
        if ($request->file('image')) {

            // Proses upload file
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '_' . $fileName;

            // Simpan file ke disk 'public' di folder 'items'
            Storage::disk('public')->putFileAs('items', $file, $newName);

            // Tambahkan nama file ke array data
            $data['image'] = $newName;
        }

        // Simpan data ke database
        $item = Item::create($data);

        return response(['data' => $item]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'nama' => 'required|max:225',
            'harga' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png',
        ]);

        $data = $request->only(['nama', 'harga']);

        if ($request->file('image')) {
            // Proses upload file
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $newName = Carbon::now()->timestamp . '_' . $fileName;

            // Simpan file ke disk 'public' di folder 'items'
            Storage::disk('public')->putFileAs('items', $file, $newName);

            // Tambahkan nama file ke array data
            $data['image'] = $newName;
        }

        $item = Item::findorfail($id);
        $item->update($data);
        return response(['data' => $item]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findorfail($id);

        if($item->image) {
            Storage::disk('public')->delete('items/' . $item->image);
        }

        $item->delete();

        return response(['data' => $item], 200);
    }
}
