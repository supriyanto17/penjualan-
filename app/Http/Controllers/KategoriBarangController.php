<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Models\KategoriBarangModel;


class KategoriBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KategoriBarangModel::orderBy('id', 'DESC')->get();

        return view('kategoribarang.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategoribarang.add');
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
            'txt_kategori' => 'required',
        ],
        [
            'txt_kategori.required' => 'Wajib Diisi!!',
        ]);

        $savebarang = KategoriBarangModel::create([
            'kategori_barang' => $request->input('txt_kategori')
        ]);

        return redirect('/kategori-barang')->with('success','Berhasil menambahkan data');
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
        $data = KategoriBarangModel::where('id', $id)->first();
        return view('kategoribarang.edit', ['data' => $data]);
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
            'txt_kategori' => 'required',
        ],
        [
            'txt_kategori.required' => 'Wajib Diisi!!',
        ]);

        KategoriBarangModel::where('id', $request->id)->update([
            'kategori_barang' => $request->txt_kategori,
        ]);
        return redirect('/kategori-barang')->with('success','Berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = KategoriBarangModel::where('id', $id)->first();

        $hapus = KategoriBarangModel::destroy($barang->id);

        return redirect('/kategori-barang')->with('success','Berhasil menghapus data.');
    }
}
