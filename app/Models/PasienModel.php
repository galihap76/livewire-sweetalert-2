<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasienModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_pasien';
    protected $fillable = [
        'nama',
        'umur',
        'alamat'
    ];
    public $timestamps = false;
}
