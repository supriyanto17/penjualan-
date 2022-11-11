<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangModel extends Model
{
    use HasFactory;
    protected $table = 'tb_keranjang';

    protected $fillable = [
        'nama_barang',
        'transaksi_id',
        'kuantiti',
        'total',
    ];
}
