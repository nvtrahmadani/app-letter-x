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
        'start_date',
        'end_date',
        'diagnosis',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            DB::transaction(function () use ($model) {
                $year = date('Y');
                $last = DB::table('surat')
                    ->whereYear('created_at', $year)
                    ->lockForUpdate() // Mengunci baris agar tidak tabrakan
                    ->orderByDesc('id')
                    ->first();

                $lastNumber = 0;

                if ($last && $last->nomor_surat) {
                    if (preg_match('/SK-' . $year . '-(\d+)/', $last->nomor_surat, $matches)) {
                        $lastNumber = (int)$matches[1];
                    }
                }

                $nextNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
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
