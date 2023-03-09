<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPerubahanJudul extends Model
{
    use HasFactory;

    protected $table = 'log_perubahan_judul';

    protected $guarded = [];

    protected $with = ['kpSkripsi', 'user'];

    public function kpSkripsi()
    {
        return $this->belongsTo(KpSkripsi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFindByKpSkripsiId($query, $id)
    {
        $query->where('kp_skripsi_id', $id);
    }
}
