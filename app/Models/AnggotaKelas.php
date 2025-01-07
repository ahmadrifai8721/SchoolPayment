<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKelas extends Model
{
    //
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];

    public function Kelas()
    {
        return $this->belongsTo(Kelas::class, "rombongan_belajar_id", "rombongan_belajar_id");
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
