<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporan extends Model
{
    protected $fillable = ['judul_laporan','isi_laporan','tanggal_laporan','status_laporan'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_laporan');
    }
}
