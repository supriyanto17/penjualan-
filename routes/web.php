<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/penjualan', [HomeController::class, 'index'])->name('/');

Route::get('/', [BarangController::class, 'index'])->name('/barang');
Route::get('/barang', [BarangController::class, 'index'])->name('/barang');
Route::get('/barang/tambah-data', [BarangController::class, 'create'])->name('/barang/tambah-data');
Route::post('/barang/tambah-data/save', [BarangController::class, 'store'])->name('/barang/tambah-data/save');
Route::get('/barang/edit/{id}', [BarangController::class,'edit']);
Route::post('/barang/update/{id}', [BarangController::class,'update']);
Route::delete('/barang/delete/{id}', [BarangController::class,'destroy']);


Route::get('/kategori-barang', [KategoriBarangController::class, 'index'])->name('/kategori-barang');
Route::get('/kategori-barang/tambah-data', [KategoriBarangController::class, 'create'])->name('/kategori-barang/tambah-data');
Route::post('/kategori-barang/tambah-data/save', [KategoriBarangController::class, 'store'])->name('/kategori-barang/tambah-data/save');
Route::get('/kategori-barang/edit/{id}', [KategoriBarangController::class,'edit']);
Route::post('/kategori-barang/update/{id}', [KategoriBarangController::class,'update']);
Route::delete('/kategori-barang/delete/{id}', [KategoriBarangController::class,'destroy']);

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('/transaksi');
Route::get('/transaksi/add-barang/{id}', [TransaksiController::class, 'addBarang']);
Route::get('/transaksi/update-barang/{id}', [TransaksiController::class, 'updateBarang']);
Route::post('/transaksi/update-barang/store', [TransaksiController::class, 'updateBarangStore'])->name('/transaksi/update-barang/store');
Route::get('/transaksi/delete-barang/{id}', [TransaksiController::class, 'destroy']);

Route::post('/transaksi/bayar-barang/store', [TransaksiController::class, 'bayarBarangStore'])->name('/transaksi/bayar-barang/store');
