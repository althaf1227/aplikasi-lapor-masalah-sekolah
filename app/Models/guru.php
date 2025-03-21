<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class guru extends Model
{
    protected $fillable = ['nama'];
    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_guru');
    }
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_guru');
    }
}
