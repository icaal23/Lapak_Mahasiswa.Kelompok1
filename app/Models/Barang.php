<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Barang extends Model
{
    protected $fillable = [
        'user_id', 'nama', 'kategori', 'harga', 'kondisi',
        'deskripsi', 'lokasi', 'foto', 'status',
        'nama_pembeli', 'harga_jual', 'terjual_pada',
    ];

    protected $casts = [
        'foto' => 'array',
        'harga_jual' => 'integer',
        'terjual_pada' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTerjual(Builder $query): Builder
    {
        return $query->where('status', 'terjual');
    }

    /**
     * Nilai yang dihitung sebagai pendapatan: harga jual yang dicatat,
     * atau harga tawar kalau harga jual tidak pernah diisi.
     */
    public function getPendapatanAttribute(): int
    {
        return (int) ($this->harga_jual ?? $this->harga);
    }

    /**
     * Tanggal terjual; untuk data lama tanpa tanggal, pakai waktu terakhir diubah.
     */
    public function getTanggalTerjualAttribute(): Carbon
    {
        return $this->terjual_pada ?? $this->updated_at;
    }
}
