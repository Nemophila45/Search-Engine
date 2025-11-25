<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'no_rekam_medis',
        'nik',
        'nama',
        'tanggal_lahir',
        'alamat',
        'jenis_kelamin',
        'no_hp',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi riwayat medis pasien.
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Hitung umur secara dinamis.
     */
    public function getUmurAttribute(): ?int
    {
        return $this->tanggal_lahir?->age;
    }
}
