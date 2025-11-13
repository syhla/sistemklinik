@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-teal-50 p-8 space-y-8">

    <!-- Header -->
    <div class="bg-gradient-to-r from-teal-400 to-teal-600 text-white p-6 rounded-2xl shadow-lg flex justify-between items-center">
        <h1 class="text-2xl font-bold"> Stok Obat</h1>
        <a href="{{ route('apoteker.dashboard') }}" 
           class="bg-white text-teal-600 px-4 py-2 rounded-xl shadow hover:bg-teal-100">
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Stok Obat -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-teal-700">Daftar Obat</h2>
        </div>

        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-teal-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Obat</th>
                    <th class="border border-gray-300 px-4 py-2">Stok Awal</th>
                    <th class="border border-gray-300 px-4 py-2">Pengeluaran</th>
                    <th class="border border-gray-300 px-4 py-2">Sisa Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($obats as $index => $obat)
                    @php
                        $stokAwal = 100; // dummy stok awal
                        $pengeluaran = $obat->stok; // diasumsikan stok = jumlah keluar
                        $sisaStok = $stokAwal - $pengeluaran;
                    @endphp
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $index+1 }}</td>
                        <td class="border px-4 py-2">{{ $obat->nama }}</td>
                        <td class="border px-4 py-2 text-center">{{ $stokAwal }}</td>
                        <td class="border px-4 py-2 text-center">{{ $pengeluaran }}</td>
                        <td class="border px-4 py-2 text-center font-semibold {{ $sisaStok <= 10 ? 'text-red-500' : 'text-green-600' }}">
                            {{ $sisaStok }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data obat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
