<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::latest()->get(); // urutkan terbaru dulu
        return view('pasien.index', compact('pasiens'));
    }

    public function store(Request $request)
    {
        Pasien::create(array_merge($request->except('_token'), [
            'status' => 'Menunggu pemeriksaan' // status default
        ]));

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->except('_token'));
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui');
    }

    // -----------------------------
    // DOKTER: UPDATE DIAGNOSA / RESEP
    // -----------------------------

    // Tampilkan pasien untuk dokter
    public function pasienUntukDokter()
    {
        $pasiens = Pasien::where('status', 'Menunggu pemeriksaan')->get();
        return view('dokter.pasien', compact('pasiens'));
    }

    // Update oleh dokter
    public function updateByDokter(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $pasien->update([
            'diagnosa' => $request->diagnosa,
            'resep'    => $request->resep,
            'status'   => 'Selesai', // lebih konsisten
        ]);

        return redirect()->route('dokter.pasien')->with('success', 'Data pasien berhasil diperiksa dokter');
    }
}
