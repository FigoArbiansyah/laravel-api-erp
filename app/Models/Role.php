<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ADMIN = 1;
    public const KARYAWAN = 2;

    protected $fillable = [
        "name",
    ];
}
