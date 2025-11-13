<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $guarded = ['id', '_token'];

     protected $fillable = [
        'nama',
        'divisi',
        'keluhan',
        'dokter_tujuan',
        'status',
        'dokter_id',
        'hasil_pemeriksaan',
        'resep_obat',
        'catatan',
    ];

    public function dokter()
{
    return $this->belongsTo(User::class, 'dokter_id'); 
}

}
