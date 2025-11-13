<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Obat;

class ApotekerController extends Controller
{
    // Dashboard apoteker
    public function index()
    {
        // Ambil semua pasien yang punya resep + dokter
        $reseps = Pasien::with('dokter')
                    ->whereNotNull('resep_obat')
                    ->orderBy('created_at', 'desc')
                    ->get();

        $obats = Obat::all(); // semua stok obat

        // Riwayat obat pasien yang sudah selesai
        $riwayatObat = Pasien::where('status', 'selesai')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('apoteker.dashboard', compact('reseps', 'obats', 'riwayatObat'));
    }

    // 👇 Tandai resep sudah dibaca (baru → selesai)
    public function terima($id)
    {
        $pasien = Pasien::findOrFail($id);

        // Kalau status masih "baru", ubah jadi "selesai"
        if ($pasien->status === 'baru') {
            $pasien->status = 'selesai';
            $pasien->save();
        }

        return response()->json(['success' => true]);
    }

    // Tandai resep sedang diproses
    public function proses($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->status = 'proses';
        $pasien->save();

        return response()->json(['success' => true]);
    }

    // Tandai resep selesai + update stok obat
    public function selesai(Request $request, $id)
    {
        $request->validate([
            'obat_diberikan' => 'required|string|max:255',
            'jumlah_obat'    => 'required|integer|min:1',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->obat_diberikan = $request->obat_diberikan;
        $pasien->jumlah_obat = $request->jumlah_obat;
        $pasien->apoteker_nama = auth()->user()->name;
        $pasien->status = 'selesai';
        $pasien->save();

        // === Update stok obat ===
        $obat = Obat::firstOrCreate(
            ['nama' => $request->obat_diberikan],
            ['stok' => 0]
        );
        $obat->stok += $request->jumlah_obat;
        $obat->save();

        return redirect()->route('apoteker.dashboard')
                         ->with('success', 'Resep pasien berhasil diproses & stok obat diperbarui!');
    }

    // Update stok obat manual
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $obat = Obat::findOrFail($id);
        $obat->stok = $request->stok;
        $obat->save();

        return redirect()->route('apoteker.dashboard')
                         ->with('success', 'Stok obat berhasil diperbarui!');
    }

    // Tambah obat baru
    public function storeObat(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0'
        ]);

        Obat::create([
            'nama' => $request->nama,
            'stok' => $request->stok
        ]);

        return redirect()->route('apoteker.dashboard')
                         ->with('success', 'Obat baru berhasil ditambahkan!');
    }

    // Hapus obat + reset pasien yg sudah selesai
    public function hapusObat($id)
    {
        $obat = Obat::findOrFail($id);

        // Reset pasien yg sudah selesai pakai obat ini
        Pasien::where('obat_diberikan', $obat->nama)
              ->where('status', 'selesai')
              ->update([
                  'status' => 'baru',
                  'obat_diberikan' => null,
                  'jumlah_obat' => null,
                  'apoteker_nama' => null
              ]);

        // Hapus obat dari tabel stok
        $obat->delete();

        return redirect()->route('apoteker.dashboard')
                         ->with('success', 'Obat berhasil dihapus & resep pasien terkait di-reset!');
    }

    // Halaman stok obat
public function stok()
{
    $obats = Obat::all();
    return view('apoteker.stok', compact('obats'));
}

}
