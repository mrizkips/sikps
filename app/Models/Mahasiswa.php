<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'mahasiswa';

    /**
     * Mass assignment guard
     *
     * @var array
     */
    protected $guarded = [];

    public function getJurusan()
    {
        if ($this->jurusan == 1) {
            return 'Sistem Informasi';
        }
        else if ($this->jurusan == 2) {
            return 'Teknik Informatika';
        }
        else {
            return null;
        }
    }

    /**
     * Get user related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
