<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $fillable = [
        'policlinic'
    ];


       public function surat()
    {
        return $this->hasMany(Surat::class);
    }
}
