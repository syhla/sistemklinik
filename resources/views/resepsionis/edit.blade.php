@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F5F5] p-6 flex items-center justify-center">
    <div class="w-full max-w-3xl bg-white shadow-xl rounded-2xl p-8 border-t-8 border-[#20B2AA]">

        {{-- Judul --}}
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-extrabold text-[#20B2AA] flex items-center justify-center gap-2">
                 Edit Data Pasien
            </h1>
            <p class="text-gray-500 text-sm mt-3">Perbarui informasi pasien dengan benar</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('resepsionis.update', $pasien->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Nama Pasien --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Nama Pasien</label>
                    <input type="text" name="nama" value="{{ $pasien->nama }}" 
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required>
                </div>

                {{-- Divisi --}}
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Divisi</label>
                    <input type="text" name="divisi" value="{{ $pasien->divisi }}" 
                           class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required>
                </div>

                {{-- Keluhan --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Keluhan</label>
                    <textarea name="keluhan" rows="3" 
                              class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required>{{ $pasien->keluhan }}</textarea>
                </div>

                {{-- Dokter Tujuan --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-semibold mb-1">Dokter Tujuan</label>
                    <select name="dokter_tujuan" 
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#20B2AA] focus:outline-none" required>
                        <option value="umum" {{ $pasien->dokter_tujuan == 'umum' ? 'selected' : '' }}>Dokter Umum</option>
                        <option value="gigi" {{ $pasien->dokter_tujuan == 'gigi' ? 'selected' : '' }}>Dokter Gigi</option>
                        <option value="bidan" {{ $pasien->dokter_tujuan == 'bidan' ? 'selected' : '' }}>Bidan</option>
                    </select>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('resepsionis.dashboard') }}" 
                   class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg font-medium shadow transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-5 py-2 bg-[#20B2AA] hover:bg-[#1b9a92] text-white rounded-lg font-semibold shadow-md transition">
                    ✅ Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
