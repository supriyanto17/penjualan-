<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiModel extends Model
{
    use HasFactory;
    protected $table = 'tb_detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'kuantiti',
        'total',
    ];
}
