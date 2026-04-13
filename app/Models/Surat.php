<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Surat extends Model
{
    protected $table = 'surat';

    protected $fillable = [
    'doctor_id',
    'poli_id',
    'patient_name',
    'nomor_surat', // Tambahkan ini
    'start_date',
    'end_date',
    'diagnosis',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            // Memastikan penomoran berjalan dalam satu kesatuan transaksi database
            DB::transaction(function () use ($model) {
                $year = date('Y');

                // Ambil data terakhir untuk tahun berjalan
                $last = DB::table('surat')
                    ->whereYear('created_at', $year)
                    ->lockForUpdate()
                    ->orderBy('id', 'desc')
                    ->first();

                $lastNumber = 0;

                if ($last && !empty($last->nomor_surat)) {
                    // Ambil angka setelah format SK-YYYY-
                    if (preg_match('/SK-' . $year . '-(\d+)/', $last->nomor_surat, $matches)) {
                        $lastNumber = (int)$matches[1];
                    }
                }

                $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

                // Mengisi kolom nomor_surat secara otomatis
                $model->nomor_surat = "SK-{$year}-{$nextNumber}";
            });
        });
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}
