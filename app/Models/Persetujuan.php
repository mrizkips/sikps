<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'persetujuan';

    /**
     * Assign guarded fields
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => '0',
    ];


    public function getStatus()
    {
        if ($this->status == 0) {
            return 'Menunggu';
        }
        else if ($this->status == 1) {
            return 'Diterima';
        }
        else if ($this->status == 2) {
            return 'Ditolak';
        }
        else {
            return $this->status;
        }
    }

    /**
     * Get pengajuan related to this resource
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
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

    /**
     * Update resource status to accepted
     *
     * @return bool
     */
    public function accept(User $user = null, $catatan = null)
    {
        return $this->update([
            'status' => '1',
            'user_id' => $user->id ?? auth()->user()->id,
            'catatan' => $catatan,
        ]);
    }

    /**
     * Update resource status to rejected
     *
     * @return bool
     */
    public function reject(User $user = null, $catatan = null)
    {
        return $this->update([
            'status' => '2',
            'user_id' => $user->id ?? auth()->user()->id,
            'catatan' => $catatan,
        ]);
    }
}
