<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function MethodePembayaran(): BelongsTo
    {
        return $this->belongsTo(MethodePembayaran::class);
    }
    public function Tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class);
    }
}
