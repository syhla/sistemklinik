@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#F5F5F5] p-8 space-y-10">

    <!-- Header -->
    <div class="bg-gradient-to-r from-[#20B2AA] to-[#1A8E88] shadow-lg rounded-xl p-8 relative flex items-center justify-center text-white">
        <div class="text-center z-10">
            <h1 class="text-4xl font-extrabold mb-2">Dashboard Apoteker</h1>
            <p class="font-medium">{{ auth()->user()->name }} • {{ auth()->user()->email }}</p>
        </div>
        <div class="absolute right-8 top-1/2 transform -translate-y-1/2 w-16 h-16">
            <img src="https://cdn-icons-png.flaticon.com/512/387/387561.png" alt="Ilustrasi Dokter" class="w-full h-full object-contain">
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Notifikasi Resep -->
    <div class="space-y-6">
        @forelse($reseps as $resep)
            <div class="bg-white shadow-md rounded-2xl overflow-hidden transition hover:shadow-lg">
                <!-- Header Card -->
                <div onclick="toggleDetail({{ $resep->id }})" class="flex justify-between items-center p-5 cursor-pointer hover:bg-teal-50 transition relative">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#20B2AA] to-[#1A8E88] flex items-center justify-center text-white font-bold shadow">
                            {{ strtoupper(substr($resep->dokter->name ?? 'D', 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ $resep->pasien->nama ?? $resep->nama }}
                                @if($resep->status === 'baru')
                                    <span id="badge-{{ $resep->id }}" class="ml-2 text-xs bg-red-500 text-white px-2 py-0.5 rounded-full font-medium">Baru</span>
                                @elseif($resep->status === 'proses')
                                    <span id="badge-{{ $resep->id }}" class="ml-2 text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full font-medium">Proses</span>
                                @elseif($resep->status === 'selesai')
                                    <span id="badge-{{ $resep->id }}" class="ml-2 text-xs bg-green-500 text-white px-2 py-0.5 rounded-full font-medium">Selesai</span>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500">Dari: {{ $resep->dokter->name ?? 'Dokter' }}</p>
                        </div>
                    </div>
                    <svg id="icon-{{ $resep->id }}" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#20B2AA] transform transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>

                <!-- Detail Hidden -->
                <div id="detail-{{ $resep->id }}" class="hidden px-6 pb-6 pt-2 border-t border-gray-100 animate-slideDown">
                    <!-- Info Pasien & Resep -->
                    <div class="bg-gray-50 rounded-xl p-4 mb-4">
                        <p class="text-sm text-gray-600"><span class="font-medium">Pasien:</span> {{ $resep->pasien->nama ?? $resep->nama }}</p>
                        <p class="text-sm text-gray-600"><span class="font-medium">Keluhan:</span> {{ $resep->pasien->keluhan ?? $resep->keluhan }}</p>
                        <p class="text-sm text-gray-700 font-medium italic">Resep: {{ $resep->nama_obat ?? $resep->resep_obat }}</p>
                    </div>

                    <!-- Status & Form -->
                    @if($resep->status !== 'selesai')
                        <div id="status-{{ $resep->id }}" class="mb-4 p-3 bg-gray-100 border border-gray-200 text-gray-700 rounded-lg text-sm font-medium">
                            {{ $resep->status === 'proses' ? '🟡 Apoteker sedang menyiapkan obat' : '⏳ Belum diproses' }}
                        </div>

                        @if($resep->status !== 'proses')
                            <button type="button" onclick="setProses({{ $resep->id }})" id="btn-proses-{{ $resep->id }}" class="bg-yellow-500 text-white px-5 py-2 rounded-lg shadow hover:bg-yellow-600 transition">
                                Sedang Proses
                            </button>
                        @endif

                        <form id="form-{{ $resep->id }}" action="{{ route('apoteker.selesai', $resep->id) }}" method="POST" class="space-y-4 hidden mt-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Nama Obat yang Diberikan</label>
                                <input type="text" name="obat_diberikan" class="w-full border rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#20B2AA]" required>
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Jumlah Obat</label>
                                <input type="number" name="jumlah_obat" class="w-full border rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#20B2AA]" required>
                            </div>
                            <button type="submit" class="bg-gradient-to-r from-[#20B2AA] to-[#1A8E88] text-white px-5 py-2 rounded-lg shadow hover:opacity-90 transition">
                                Selesai
                            </button>
                        </form>
                    @else
                        <span class="mt-2 inline-block text-green-600 font-medium">
                            Obat sudah diserahkan oleh {{ $resep->apoteker_nama }} 
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-400 italic text-center">Belum ada resep masuk</p>
        @endforelse
    </div>

<!-- Tombol Stock Obat -->
<a href="{{ route('apoteker.stok.index') }}" 
class="w-full text-center block bg-gradient-to-r from-[#20B2AA] to-[#1A8E88] text-white py-4 rounded-2xl shadow hover:opacity-90 transition text-lg font-semibold"> 
 Stok Obat
</a>





    <!-- Modal Stock Obat -->
    <div id="stockModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-lg w-3/4 max-w-3xl p-6 relative">
            <button onclick="toggleStockModal()" class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-2xl">&times;</button>
            

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-gray-100">
                        <th class="p-2">Nama Obat</th>
                        <th class="p-2">Stok Awal</th>
                        <th class="p-2">Pengeluaran</th>
                        <th class="p-2">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dummyStok = [
                            'Paracetamol' => 100,
                            'Amoxicillin' => 80,
                            'Vitamin C' => 120,
                            'Ibuprofen' => 75,
                            'Cetirizine' => 60,
                            'Ranitidine' => 50,
                            'Metformin' => 90,
                            'Amlodipine' => 70,
                            'Omeprazole' => 85,
                            
                        ];
                    @endphp

                    @foreach($dummyStok as $namaObat => $stokAwal)
                        @php
                            $pengeluaran = $reseps->where('status', 'selesai')
                                ->where('obat_diberikan', $namaObat)
                                ->sum('jumlah_obat');
                            $sisa = $stokAwal - $pengeluaran;
                        @endphp
                        <tr class="border-b">
                            <td class="p-2">{{ $namaObat }}</td>
                            <td class="p-2">{{ $stokAwal }}</td>
                            <td class="p-2">{{ $pengeluaran }}</td>
                            <td class="p-2 font-semibold {{ $sisa <= 10 ? 'text-red-500' : 'text-green-600' }}">
                                {{ $sisa }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Manajemen Stok Obat -->
    <div class="bg-white shadow-md rounded-2xl p-6 mt-10">
        <h2 class="text-xl font-bold mb-4">Pengeluaran Obat</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-2">Nama Obat</th>
                    <th class="p-2">Jumlah diberikan</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obats as $obat)
                <tr class="border-b">
                    <td class="p-2">{{ $obat->nama }}</td>
                    <td class="p-2">{{ $obat->stok }}</td>
                    <td class="p-2 flex gap-2">
                        <!-- Update & Hapus -->
                        <div class="flex gap-2">
                            <!-- Update Stok -->
                            <form action="{{ route('apoteker.stok.update', $obat->id) }}" method="POST" class="flex gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="stok" value="{{ $obat->stok }}" 
                                    class="border p-2 rounded-lg w-20 focus:ring focus:ring-blue-300">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                                    Update
                                </button>
                            </form>

                            <!-- Hapus Obat -->
                            <form action="{{ route('apoteker.stok.hapus', $obat->id) }}" method="POST" 
                                onsubmit="return confirm('Yakin mau hapus obat ini? Semua pasien terkait akan kembali ke status baru!')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
    function toggleDetail(id) {
        const detail = document.getElementById('detail-' + id);
        const icon = document.getElementById('icon-' + id);
        detail.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');

        const badge = document.getElementById('badge-' + id);
        if(badge && badge.innerText === 'Baru') {
            badge.innerText = 'Dibaca';
            badge.classList.remove('bg-red-500');
            badge.classList.add('bg-green-500');

            fetch(`/apoteker/terima/${id}`, { 
                method: 'POST', 
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} 
            });
        }
    }

    function setProses(id) {
        document.getElementById('status-' + id).innerHTML = " Apoteker sedang menyiapkan obat";
        document.getElementById('btn-proses-' + id).classList.add('hidden');
        document.getElementById('form-' + id).classList.remove('hidden');

        const badge = document.getElementById('badge-' + id);
        if(badge) {
            badge.innerText = 'Proses';
            badge.classList.remove('bg-red-500', 'bg-green-500');
            badge.classList.add('bg-yellow-500');

            fetch(`/apoteker/proses/${id}`, { 
                method: 'POST', 
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'} 
            });
        }
    }

    function toggleStockModal() {
        document.getElementById('stockModal').classList.toggle('hidden');
    }
</script>

<style>
    @keyframes slideDown {0% {opacity: 0; transform: translateY(-10px);} 100% {opacity: 1; transform: translateY(0);}}
    .animate-slideDown {animation: slideDown 0.3s ease-out;}
</style>
@endsection
