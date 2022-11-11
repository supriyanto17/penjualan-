<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\BarangModel;
use App\Models\StokBarangModel;
use App\Models\KategoriBarangModel;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BarangModel::join('tb_kategori_barang', 'tb_barang.jenis_barang_id', '=', 'tb_kategori_barang.id')
                ->join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
                ->orderBy('tb_barang.id', 'DESC')
                ->get(['tb_barang.*', 'tb_kategori_barang.kategori_barang', 'tb_stok.stok']);

        return view('barang.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = KategoriBarangModel::orderBy('id', 'DESC')->get();
        return view('barang.add', ['kategori' => $kategori]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'txt_barang' => 'required',
            'txt_harga' => 'required|numeric',
            'txt_stok' => 'required|numeric',
            'txt_kategori_barang' => 'required',
        ],
        [
            'txt_barang.required' => 'Wajib Diisi!!',
            'txt_harga.required' => 'Wajib Diisi!!',
            'txt_harga.numeric' => 'Wajib Diisi Angka!!',
            'txt_stok.required' => 'Wajib Diisi!!',
            'txt_stok.numeric' => 'Wajib Diisi Angka!!',
            'txt_kategori_barang.required' => 'Wajib Diisi!!',
        ]);

        $savebarang = BarangModel::create([
            'nama_barang' => $request->input('txt_barang'),
            'harga' => $request->input('txt_harga'),
            'jenis_barang_id' => $request->input('txt_kategori_barang'),
            'status_keranjang' => '0'
        ]);

        if($savebarang){
            $barang_id = BarangModel::latest()->first();
            $stok = StokBarangModel::create([
                'stok' => $request->input('txt_stok'),
                'barang_id' => $barang_id->id
            ]);

            return redirect('/barang')->with('success','Berhasil menambahkan data');
        }
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
        $data = BarangModel::join('tb_kategori_barang', 'tb_barang.jenis_barang_id', '=', 'tb_kategori_barang.id')
                ->join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
                ->where('tb_barang.id', $id)
                ->first(['tb_barang.*', 'tb_kategori_barang.kategori_barang', 'tb_stok.stok']);

        $kategori = KategoriBarangModel::orderBy('id', 'DESC')->get();
        return view('barang.edit', ['data' => $data, 'kategori' => $kategori]);
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
        $validatedData = $request->validate([
            'txt_barang' => 'required',
            'txt_harga' => 'required|numeric',
            'txt_stok' => 'required|numeric',
            'txt_kategori_barang' => 'required',
        ],
        [
            'txt_barang.required' => 'Wajib Diisi!!',
            'txt_harga.required' => 'Wajib Diisi!!',
            'txt_harga.numeric' => 'Wajib Diisi Angka!!',
            'txt_stok.required' => 'Wajib Diisi!!',
            'txt_stok.numeric' => 'Wajib Diisi Angka!!',
            'txt_kategori_barang.required' => 'Wajib Diisi!!',
        ]);

        $editbarang = BarangModel::where('id', $request->id)->update([
                'nama_barang' => $request->txt_barang,
                'harga' => $request->txt_harga,
                'jenis_barang_id' => $request->txt_kategori_barang
            ]);

        $editstok = StokBarangModel::where('barang_id', $request->id)->update([
            'stok' => $request->txt_stok,
        ]);

        return redirect('/barang')->with('success','Berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapusstokbarang = StokBarangModel::where('barang_id', $id)->delete();
        if($hapusstokbarang){;
            BarangModel::destroy($id);
            return redirect('/barang')->with('success','Berhasil menghapus data.');
        }

    }
}
