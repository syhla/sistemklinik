@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8 font-sans space-y-8">

    <!-- Profil Dokter di Atas -->
    <div class="mb-6 border-b pb-4">
        <h1 class="text-3xl font-bold text-teal-700">Dashboard Dokter Gigi</h1>
        <p class="mt-1 text-gray-600 text-base">
            Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span>!  
            Semoga harimu menyenangkan dan tetap semangat melayani pasien hari ini.
        </p>
        <div class="mt-4 flex items-center gap-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff&rounded=true"
                 alt="Avatar Dokter Gigi"
                 class="w-16 h-16 rounded-full border-2 border-white shadow">
            <div>
                <h2 class="text-lg font-bold text-teal-700">drg. {{ auth()->user()->name }}</h2>
                <p class="text-gray-600 text-sm">{{ auth()->user()->email }}</p>
                <span class="inline-block mt-1 bg-teal-600 text-white text-xs px-3 py-1 rounded-full shadow">
                    Dokter Gigi
                </span>
            </div>
        </div>
    </div>

    <!-- Daftar Pesan Masuk -->
    <div class="bg-white shadow-md rounded-2xl p-6">
        <h2 class="text-xl font-bold mb-4 text-teal-600">Pesan Masuk</h2>
        <p class="text-gray-700 mb-4">
            Jumlah pesan belum diterima: 
            <span id="unread-count" class="font-bold text-teal-600">
                {{ $pasiens->where('selesai', false)->count() }}
            </span>
        </p>

        <div id="messages-container" class="space-y-4">
            @forelse ($pasiens->where('selesai', false) as $pasien)
                <div id="msg-{{ $pasien->id }}" 
                    class="border border-gray-200 rounded-xl p-4 flex justify-between items-center bg-gray-50 hover:shadow-md transition">
                    <div>
                        <p class="font-semibold text-gray-800">Nama: <span class="font-normal">{{ $pasien->nama }}</span></p>
                        <p class="font-semibold text-gray-800">Divisi: <span class="font-normal">{{ $pasien->divisi }}</span></p>
                        <p class="font-semibold text-gray-800">Keluhan: <span class="font-normal">{{ $pasien->keluhan }}</span></p>
                    </div>
                    <button type="button" 
                        onclick="acceptMessage({{ $pasien->id }}, '{{ $pasien->nama }}', '{{ $pasien->divisi }}', '{{ $pasien->keluhan }}')" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 hover:scale-105 transition">
                        Terima Pesan
                    </button>
                </div>
            @empty
                <p class="text-gray-400 italic">Tidak ada pesan baru</p>
            @endforelse
        </div>
    </div>

    <!-- Form Detail Pasien -->
    <div id="forms-container" class="space-y-6"></div>

    <!-- Riwayat Pasien -->
    <div class="bg-white shadow-md rounded-2xl p-6">
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-xl font-bold text-teal-700">Riwayat Pasien</h2>
            <button type="button" onclick="toggleHistory()" 
                class="bg-gray-700 text-white px-5 py-2 rounded-lg hover:scale-105 transition">
                Lihat Riwayat
            </button>
        </div>

        <div id="history-container" class="mt-4 hidden overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 rounded-xl overflow-hidden shadow-sm text-sm">
                <thead>
                    <tr class="bg-teal-100 text-teal-800">
                        <th class="border px-4 py-2 text-left">Tanggal</th>
                        <th class="border px-4 py-2 text-left">Nama Pasien</th>
                        <th class="border px-4 py-2 text-left">Keluhan</th>
                        <th class="border px-4 py-2 text-left">Hasil Pemeriksaan</th>
                        <th class="border px-4 py-2 text-left">Resep</th>
                        <th class="border px-4 py-2 text-left">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pasiens->where('selesai', true)->sortByDesc('updated_at') as $pasien)
                    <tr class="hover:bg-teal-50 transition">
                        <td class="border px-4 py-2">
                            {{ \Carbon\Carbon::parse($pasien->updated_at)->format('d M Y') }}
                        </td>
                        <td class="border px-4 py-2">{{ $pasien->nama }}</td>
                        <td class="border px-4 py-2">{{ $pasien->keluhan }}</td>
                        <td class="border px-4 py-2">{{ $pasien->hasil_pemeriksaan }}</td>
                        <td class="border px-4 py-2">{{ $pasien->resep_obat }}</td>
                        <td class="border px-4 py-2">{{ $pasien->catatan }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-400 italic">
                                Belum ada riwayat pasien
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function acceptMessage(id, nama, divisi, keluhan) {
        fetch('/doktergigi/terima/' + id, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                const msgCard = document.getElementById('msg-' + id);
                if(msgCard) msgCard.remove();

                const unreadCountEl = document.getElementById('unread-count');
                let currentCount = parseInt(unreadCountEl.innerText);
                unreadCountEl.innerText = currentCount > 0 ? currentCount - 1 : 0;

                if (parseInt(unreadCountEl.innerText) === 0) {
                    document.getElementById('messages-container').innerHTML = 
                        '<p class="text-gray-500 italic">Tidak ada pesan baru</p>';
                }

                const formsContainer = document.getElementById('forms-container');
                formsContainer.innerHTML += `
                    <form action="/doktergigi/selesai/${id}" method="POST" 
                        class="bg-white shadow-md rounded-2xl p-6 space-y-4 border-l-4 border-teal-500">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">

                        <h3 class="font-bold text-lg mb-2 text-teal-700">Detail Pasien</h3>
                        <p><span class="font-semibold">Nama:</span> ${nama}</p>
                        <p><span class="font-semibold">Divisi:</span> ${divisi}</p>
                        <p><span class="font-semibold">Keluhan:</span> ${keluhan}</p>

                        <div>
                            <label class="block font-semibold mb-1">Hasil Pemeriksaan</label>
                            <textarea name="hasil_pemeriksaan" rows="3" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-teal-300"></textarea>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Resep Obat</label>
                            <textarea name="resep_obat" rows="3" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-teal-300"></textarea>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Catatan</label>
                            <textarea name="catatan" rows="2" class="w-full border rounded-xl p-3 focus:ring-2 focus:ring-teal-300"></textarea>
                        </div>

                        <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 hover:scale-105 transition">
                            Selesai 
                        </button>
                    </form>
                `;
            }
        });
    }

    function toggleHistory() {
        const history = document.getElementById('history-container');
        if(history){
            history.classList.toggle('hidden');
        }
    }
</script>
@endsection
