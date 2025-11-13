<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'reseps'; // pastikan tabelnya reseps
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'nama_obat',
        'jumlah_obat',
        'status', // contoh: baru, diproses, selesai
    ];

    // Relasi ke pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    // Relasi ke dokter
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
