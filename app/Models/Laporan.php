<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
        'status',
        'user_id',
        'deskripsi_tindakan', // deskripsi admin ketika selesai
        'bukti',              // foto/video bukti selesai
        'lokasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
