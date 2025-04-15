<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\messages;
use App\Models\User;

class Conversations extends Model
{

    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'guru_id',
    ];

    public function siswa() {
        return $this->belongsTo(User::class, 'siswa_id');
    }
    
    public function guru() {
        return $this->belongsTo(User::class, 'guru_id');
    }
    
    public function messages() {
        return $this->hasMany(Messages::class, 'conversation_id');
    }
}
