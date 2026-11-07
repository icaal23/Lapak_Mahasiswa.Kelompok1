<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'user_id', 'nama', 'kategori', 'harga', 'kondisi',
        'deskripsi', 'lokasi', 'foto', 'status',
    ];

    protected $casts = [
        'foto' => 'array',
    ];
}