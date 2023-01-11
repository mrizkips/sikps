<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var mixed
     */
    protected $table = 'dosen';

    /**
     * Mass assignment guard
     *
     * @var array
     */
    protected $guarded = [];

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
