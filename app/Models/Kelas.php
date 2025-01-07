<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'rombongan_belajar_id';

    public function AnggotaKelas(): HasMany
    {
        return $this->HasMany(AnggotaKelas::class, "rombongan_belajar_id", "rombongan_belajar_id");
    }
}
