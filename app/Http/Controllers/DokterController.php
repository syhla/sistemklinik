<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;

class DokterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman dokter umum
     */
    public function umum()
    {
        $this->authorizeRole('dokter_umum');
        $pasiens = Pasien::where('dokter_tujuan', 'umum')->get();
        return view('dokter.dokterumum', compact('pasiens'));
    }


    /**
     * Halaman dokter gigi
     */
    public function gigi()
    {
        $pasiens = Pasien::where('dokter_tujuan', 'gigi')->get();
        return view('dokter.doktergigi', compact('pasiens'));    }

    /**
     * Halaman bidan
     */
    public function bidan()
    {
        $pasiens = Pasien::where('dokter_tujuan', 'bidan')->get();
        return view('dokter.bidan', compact('pasiens'));
    }

    /**
     * Update data pasien
     */
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'status'   => 'nullable|string|max:255',
            'feedback' => 'nullable|string',
        ]);

        $pasien->status   = $request->status;
        $pasien->feedback = $request->feedback;
        $pasien->save();

        return redirect()->back()->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function terima($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update(['dibaca' => true]);

        return response()->json(['success' => true]);
    }

    public function selesai(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->hasil_pemeriksaan = $request->hasil_pemeriksaan;
        $pasien->resep_obat = $request->resep_obat;
        $pasien->catatan = $request->catatan;
        $pasien->dokter_id = auth()->id();
        $pasien->selesai = true;
        // $pasien->dibaca = true; // ini WAJIB supaya gak muncul lagi
        $pasien->save();

        // cek tujuan dokter
        
        if ($pasien->dokter_tujuan === 'umum') {
            return redirect()->route('dokter.dokterumum')->with('success', 'Pasien selesai diperiksa oleh dokter umum');
        } elseif ($pasien->dokter_tujuan === 'gigi') {
            return redirect()->route('dokter.doktergigi')->with('success', 'Pasien selesai diperiksa oleh dokter gigi');
        } elseif ($pasien->dokter_tujuan === 'bidan') {
            return redirect()->route('dokter.bidan')->with('success', 'Pasien selesai diperiksa oleh bidan');
        }

        // default fallback
        return redirect()->back()->with('success', 'Pasien selesai diperiksa');

    }

    /**
     * Fungsi private untuk cek role
     */
    private function authorizeRole(string $neededRole): void
    {
        $user = auth()->user();
        if (!$user) {
            abort(401, 'Silakan login terlebih dahulu.');
        }
        if ($user->role !== $neededRole) {
            abort(403, 'Tidak punya akses ke halaman ini.');
        }
    }
}
