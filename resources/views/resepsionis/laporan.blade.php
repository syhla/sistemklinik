@extends('layouts.app')

@section('content')
<div class="min-h-screen p-6">
    <div class="bg-white shadow-xl rounded-2xl p-8 border-t-8 border-[#20B2AA]">
        
<h1 class="text-2xl md:text-3xl font-extrabold text-[#20B2AA] flex items-center gap-2 mb-6">
     Laporan Pasien 
    <span class="px-3 py-1 rounded-full text-sm font-semibold
        @if($filter === 'today') bg-blue-100 text-blue-700 
        @elseif($filter === 'week') bg-green-100 text-green-700 
        @elseif($filter === 'month') bg-yellow-100 text-yellow-700 
        @else bg-gray-100 text-gray-700 
        @endif">
        @if($filter === 'today') Hari Ini ({{ now()->format('d M Y') }})
        @elseif($filter === 'week') Minggu Ini
        @elseif($filter === 'month') Bulan Ini
        @else Semua Data
        @endif
    </span>
</h1>

<form method="GET" action="{{ route('resepsionis.laporan') }}" class="mb-6">
    <label for="filter" class="mr-2 font-semibold">📌 Lihat Laporan:</label>
    <select name="filter" id="filter" 
            class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-[#20B2AA] focus:outline-none"
            onchange="this.form.submit()">
        <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>Hari Ini</option>
        <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>Minggu Ini</option>
        <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>Bulan Ini</option>
        <option value="all" {{ $filter === 'all' ? 'selected' : '' }}>Semua</option>
    </select>
</form>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            <div class="p-4 bg-blue-100 rounded-lg shadow text-center">
                <p class="text-xl font-bold text-blue-700">{{ $total }}</p>
                <p class="text-sm">Total Pasien</p>
            </div>
            <div class="p-4 bg-green-100 rounded-lg shadow text-center">
                <p class="text-xl font-bold text-green-700">{{ $selesai }}</p>
                <p class="text-sm">Selesai</p>
            </div>
            <div class="p-4 bg-yellow-100 rounded-lg shadow text-center">
                <p class="text-xl font-bold text-yellow-700">{{ $menunggu }}</p>
                <p class="text-sm">Menunggu</p>
            </div>
        </div>

<div class="overflow-x-auto rounded-lg shadow-md mt-6">
    <table class="w-full border-collapse">
        <thead class="bg-[#20B2AA] text-white text-sm uppercase">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Divisi</th>
                <th class="p-3 text-left">Dokter Tujuan</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Waktu</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            @forelse($pasiens as $pasien)
                <tr class="odd:bg-white even:bg-gray-50 hover:bg-[#E0F7F5] transition">
                    <td class="p-3 font-medium text-gray-800">{{ $pasien->nama }}</td>
                    <td class="p-3 text-gray-700">{{ $pasien->divisi }}</td>
                    <td class="p-3 text-gray-700 capitalize">{{ $pasien->dokter_tujuan }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs font-semibold 
                            {{ $pasien->status === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($pasien->status) }}
                        </span>
                    </td>
                    <td class="p-3 text-gray-600">{{ $pasien->created_at->format('H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500 italic">
                        Belum ada pasien {{ $filter === 'today' ? 'hari ini' : '' }}.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
@endsection
