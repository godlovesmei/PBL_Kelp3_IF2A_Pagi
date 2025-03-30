<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::with('mobil', 'pembeli')->get();
        return view('penjual.pesanan', compact('pesanan'));
    }

    public function create()
    {
        return view('pesanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mobil' => 'required|exists:mobil,kode_mobil',
            'pembeli_id' => 'required|exists:pembeli,id',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|string',
            'total_pembayaran' => 'required|integer',
            'metode_pembayaran' => 'required|in:lunas,kredit'
        ]);

        Pesanan::create($request->all());

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Pesanan $pesanan)
    {
        return view('pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        return view('pesanan.edit', compact('pesanan'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|string',
            'metode_pembayaran' => 'required|in:lunas,kredit'
        ]);

        $pesanan->update($request->all());

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus!');
    }
}
