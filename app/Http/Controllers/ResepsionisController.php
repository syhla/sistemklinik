<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class ResepsionisController extends Controller
{
    public function dashboard()
    {
        $pasiens = Pasien::latest()->get();
        return view('resepsionis.dashboard', compact('pasiens'));
    }

    public function index()
    {
        // bisa redirect atau tampilkan daftar
        $pasiens = Pasien::latest()->get();
        return view('resepsionis.dashboard', compact('pasiens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'divisi' => 'required',
            'keluhan' => 'required',
            'dokter_tujuan' => 'required',
        ]);

        Pasien::create([
            'nama' => $request->nama,
            'divisi' => $request->divisi,
            'keluhan' => $request->keluhan,
            'dokter_tujuan' => $request->dokter_tujuan,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('resepsionis.dashboard')
                         ->with('success', 'Pasien berhasil didaftarkan!');
    }

    public function edit(Pasien $pasien)
    {
        return view('resepsionis.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required',
            'divisi' => 'required',
            'keluhan' => 'required',
            'dokter_tujuan' => 'required',
        ]);

        $pasien->update($request->all());
        return redirect()->route('resepsionis.dashboard')
                         ->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function laporan(Request $request)
{
    $filter = $request->get('filter', 'today');

    $query = Pasien::query();

    if ($filter === 'today') {
        $query->whereDate('created_at', now()->toDateString());
    } elseif ($filter === 'week') {
        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($filter === 'month') {
        $query->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
    }

    $pasiens = $query->get();

    $total    = $pasiens->count();
    $selesai  = $pasiens->where('status', 'selesai')->count();
    $menunggu = $pasiens->where('status', 'menunggu')->count();
    $batal    = $pasiens->where('status', 'batal')->count();

    return view('resepsionis.laporan', compact(
        'pasiens',
        'filter',
        'total',
        'selesai',
        'menunggu',
        'batal'
    ));
}

}
