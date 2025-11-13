@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6">
  <div class="bg-white shadow-2xl rounded-2xl p-8 border-t-8 border-[#20B2AA] fade-in-up">

    <div class="mb-6">
      <h1 class="text-3xl font-extrabold text-[#20B2AA] flex items-center gap-2">
        🩺 Dashboard Resepsionis
      </h1>
    </div>

    {{-- Form tambah pasien --}}
    <form action="{{ route('resepsionis.store') }}" method="POST" class="mb-8">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="text" name="nama" placeholder="Nama Pasien"
               class="p-3 border rounded-lg focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required>

        <input type="text" name="divisi" placeholder="Divisi Pekerjaan"
               class="p-3 border rounded-lg focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required>

        <textarea name="keluhan" placeholder="Keluhan Pasien" rows="3"
                  class="p-3 border rounded-lg col-span-2 focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required></textarea>

        <select name="dokter_tujuan"
                class="p-3 border rounded-lg col-span-2 focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required>
          <option value="">-- Pilih Dokter Tujuan --</option>
          <option value="umum">Dokter Umum</option>
          <option value="gigi">Dokter Gigi</option>
          <option value="bidan">Bidan</option>
        </select>
      </div>
      <button type="submit"
              class="mt-5 bg-[#20B2AA] hover:bg-[#1b9a92] text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
        ➕ Daftarkan Pasien
      </button>
    </form>

    {{-- Daftar pasien terbaru --}}
    <div class="flex items-center justify-between mb-4 mt-8">
      <h2 class="text-2xl font-bold text-[#20B2AA]">📋 Daftar Pasien Hari Ini</h2>
      <a href="{{ route('resepsionis.laporan') }}"
         class="bg-[#20B2AA] hover:bg-[#1b9a92] text-white font-semibold px-5 py-2 rounded-lg shadow-md transition">
        📊 Laporan Pasien
      </a>
    </div>

    <div class="overflow-x-auto rounded-lg shadow-md">
      <table class="w-full border-collapse">
        <thead class="bg-[#20B2AA] text-white text-sm uppercase">
          <tr>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Divisi</th>
            <th class="p-3 text-left">Keluhan</th>
            <th class="p-3 text-left">Dokter Tujuan</th>
            <th class="p-3 text-left">Status</th>
            <th class="p-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-sm">
          @forelse($pasiens as $pasien)
            @if($pasien->created_at->isToday())
              @php
                $statusMap = [
                  'Selesai'  => ['bg-green-100 text-green-700', '✅'],
                  'Menunggu' => ['bg-yellow-100 text-yellow-700', '⏳'],
                  'Proses'   => ['bg-blue-100 text-blue-700', '🔄'],
                  'Batal'    => ['bg-red-100 text-red-700', '❌'],
                ];
                $status = ucfirst($pasien->status);
                $badge  = $statusMap[$status] ?? ['bg-gray-100 text-gray-700', '⚪'];
              @endphp
              <tr class="hover:bg-gray-50 transition">
                <td class="p-3 font-medium text-gray-800">{{ $pasien->nama }}</td>
                <td class="p-3 text-gray-600">{{ $pasien->divisi }}</td>
                <td class="p-3 text-gray-600">{{ $pasien->keluhan }}</td>
                <td class="p-3 capitalize">{{ $pasien->dokter_tujuan }}</td>
                <td class="p-3">
                  <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badge[0] }}">
                    {{ $badge[1] }} {{ $status }}
                  </span>
                </td>
                <td class="p-3 flex gap-2 justify-center">
                  {{-- Tombol Edit --}}
                  <a href="{{ route('resepsionis.edit', $pasien->id) }}"
                     class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-sm shadow transition">
                    ✏️ Edit
                  </a>
                </td>
              </tr>
            @endif
          @empty
            <tr>
              <td colspan="6" class="p-4 text-center text-gray-500">
                Belum ada pasien terdaftar.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
