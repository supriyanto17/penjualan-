<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiModel extends Model
{
    use HasFactory;
    protected $table = 'tb_transaksi';

    protected $fillable = [
        'tanggal',
        'nama_pelanggan',
        'grand_total',
        'no_transaksi',
    ];
}
