<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarangModel extends Model
{
    use HasFactory;

    protected $table = 'tb_kategori_barang';

    protected $fillable = [
        'kategori_barang',
    ];
}
