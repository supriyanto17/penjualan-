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

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        function kodeTransaksi(){
            // mengambil data barang dengan kode paling besar
            // $query = mysqli_query($koneksi, "SELECT max(kode) as kodeTerbesar FROM barang");
            $query = DB::table('tb_transaksi')
                    ->selectRaw('max(no_transaksi) as kodeTerbesar')
                    ->first();

            $kodeBarang = $query->kodeTerbesar;

            // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
            // dan diubah ke integer dengan (int)
            $urutan = (int) substr($kodeBarang, 3, 3);

            // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
            $urutan++;

            // membentuk kode barang baru
            // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
            // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
            // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG
            $huruf = "TRN-";
            $kodeBarang = $huruf . sprintf("%03s", $urutan);
            return $kodeBarang;
        }

        $kodetrans = kodeTransaksi();

        $caribarang = BarangModel::join('tb_kategori_barang', 'tb_barang.jenis_barang_id', '=', 'tb_kategori_barang.id')
            ->join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
            ->where('tb_stok.stok','>', '0')
            ->where('tb_barang.status_keranjang','=', '0')
            ->get(['tb_barang.*', 'tb_kategori_barang.kategori_barang', 'tb_stok.stok']);

        $tanggal = Carbon::now()->format('d-m-Y H:i:s');

        $transaksibarang = BarangModel::join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
            ->join('tb_keranjang', 'tb_keranjang.nama_barang', '=', 'tb_barang.id')
            ->where('tb_barang.status_keranjang','=', '1')
            ->get(['tb_barang.*', 'tb_keranjang.id as KeranjangID', 'tb_keranjang.kuantiti', 'tb_keranjang.total', 'tb_stok.stok']);

        $grand_total = KeranjangModel::get()->sum('total');

        return view('transaksi.index',
            [
                'kodetrans' =>$kodetrans,
                'caribarang' => $caribarang,
                'tanggal' => $tanggal,
                'transaksibarang' => $transaksibarang,
                'grand_total' => $grand_total,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addBarang(Request $request, $id)
    {

        $barang = BarangModel::join('tb_kategori_barang', 'tb_barang.jenis_barang_id', '=', 'tb_kategori_barang.id')
                ->join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
                ->where('tb_barang.id','=', $id)
                ->first(['tb_barang.*', 'tb_kategori_barang.kategori_barang', 'tb_stok.stok', 'tb_stok.id as stok_id']);

        $editkeranjangbarang = BarangModel::where('id', $request->id)->update([
            'status_keranjang' => '1'
        ]);

        if($editkeranjangbarang){
            $savekeranjang = KeranjangModel::create([
                'nama_barang' => $barang->id,
                'kuantiti' => '1',
                'total' => $barang->harga,
            ]);
        }

        return redirect('/transaksi');
    }

    public function updateBarang(Request $request, $id)
    {
        if ($request->ajax()) {
            $datakeranjang = BarangModel::join('tb_keranjang', 'tb_barang.id', '=', 'tb_keranjang.nama_barang')
                    ->join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
                    ->where('tb_keranjang.id', $id)
                    ->first(['tb_barang.nama_barang as nm_barang', 'tb_barang.harga as harga_barang', 'tb_keranjang.*']);

            return response()->json($datakeranjang);
        }
    }

    public function updateBarangStore(Request $request)
    {
            $datakeranjang = BarangModel::join('tb_keranjang', 'tb_barang.id', '=', 'tb_keranjang.nama_barang')
                    ->join('tb_stok', 'tb_stok.barang_id', '=', 'tb_barang.id')
                    ->where('tb_keranjang.id', $request->txt_id_keranjang)
                    ->first(['tb_barang.nama_barang as nm_barang', 'tb_barang.harga as harga_barang', 'tb_keranjang.*']);

            $harga = $datakeranjang->harga_barang;
            $kuantiti = $request->txt_jumlah_belibarang;
            $total = ($harga*$kuantiti);

            $editkeranjang = KeranjangModel::where('id', $request->txt_id_keranjang)->update([
                'kuantiti' => $kuantiti,
                'total' => $total,
            ]);

            return response()->json(['success'=>'Berhasil Merubah Data !']);
    }

    public function bayarBarangStore(Request $request)
    {

        $validatedData = $request->validate([
            'txt_bayar' => 'required',
        ],
        [
            'txt_bayar.required' => 'Wajib Diisi !!',
        ]);

        $savetransaksi = TransaksiModel::create([
            'no_transaksi' => $request->input('txt_notransaksi'),
            'tanggal' => Carbon::now(),
            'grand_total' => $request->input('txt_grand_total'),
        ]);

        $transaksi_id = TransaksiModel::latest()->first();

        // PINDAHIN TABEL KERANJANG KE DETAIL TRANSAKSI
        $getallKeranjang = KeranjangModel::get();

        foreach ($getallKeranjang as $g){
            $savedetailtransaksi = DetailTransaksiModel::create([
                'transaksi_id' => $transaksi_id->id,
                'barang_id' => $g['nama_barang'],
                'kuantiti' => $g['kuantiti'],
                'total' => $g['total']
            ]);

            $changestatusbarang = BarangModel::where('id', $g['nama_barang'])->update([
                'status_keranjang' => 0,
            ]);

            // $changeStokbarang = StokBarangModel::where('barang_id', $g['nama_barang'])->update([
            //     'stok' => 'stok'-$g['kuantiti'],
            // ]);
            $changeStokbarang = DB::table('tb_stok')->where('barang_id', $g['nama_barang'])->decrement('stok', $g['kuantiti']);
        }

        $deleteKeranjang = KeranjangModel::truncate();

        return redirect('/transaksi')->with('success','Berhasil menambahkan transaksi');

    }


    public function create(Request $request)
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
        $databarang = BarangModel::join('tb_keranjang', 'tb_barang.id', '=', 'tb_keranjang.nama_barang')
                ->where('tb_keranjang.id', $id)
                ->first(['tb_barang.id as barang_id', 'tb_barang.nama_barang as nm_barang', 'tb_barang.status_keranjang as status_keranjang', 'tb_keranjang.*']);

        $updatestatuskeranjang = BarangModel::where('id', $databarang->barang_id)->update([
            'status_keranjang' => 0
        ]);
        KeranjangModel::find($id)->delete();
        return response()->json(['success'=>'Berhasil Menghapus Data !']);
    }
}
