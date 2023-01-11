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


    public function status(): Attribute
    {
        return Attribute::make(
            get: function ($status) {
                if ($status == 1) {
                    return 'Diterima';
                }
                else if ($status == 2) {
                    return 'Ditolak';
                }
                else {
                    return null;
                }
            }
        );
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
    public function accept(User $user = null)
    {
        return $this->update([
            'status' => '1',
            'user_id' => $user->id ?? auth()->user()->id,
        ]);
    }

    /**
     * Update resource status to rejected
     *
     * @return bool
     */
    public function reject(User $user = null)
    {
        return $this->update([
            'status' => '2',
            'user_id' => $user->id ?? auth()->user()->id,
        ]);
    }
}
