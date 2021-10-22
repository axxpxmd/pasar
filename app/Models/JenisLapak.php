<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisLapak extends Model
{
    protected $table    = 'tm_jenis_lapaks';
    protected $fillable = ['id', 'nm_jenis_lapak', 'created_at', 'updated_at'];
}
