<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

use App\Models\BarangModel;
use App\Models\StokBarangModel;
use App\Models\KategoriBarangModel;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\KeranjangModel;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BarangModel::join('tb_detail_transaksi', 'tb_barang.id', '=', 'tb_detail_transaksi.barang_id')
                ->join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
                ->join('tb_kategori_barang', 'tb_kategori_barang.id', '=', 'tb_barang.jenis_barang_id')
                ->join('tb_transaksi', 'tb_transaksi.id', '=', 'tb_detail_transaksi.transaksi_id')
                ->orderBy('tb_barang.id', 'DESC')
                ->get([
                    'tb_barang.*',
                    'tb_stok.stok',
                    'tb_transaksi.no_transaksi',
                    'tb_transaksi.tanggal',
                    'tb_transaksi.grand_total',
                    'tb_kategori_barang.kategori_barang',
                    'tb_detail_transaksi.kuantiti',
                ]);

        return view('index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
