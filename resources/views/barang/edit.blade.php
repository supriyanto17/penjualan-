@php
$title='Barang';
@endphp

@extends('layouts.main')
@section('content')



    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                  <h4>Edit Data Barang</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{route('/barang')}}" class="btn btn-secondary">Kembali</a>                        
                    </div>
                    <form method="POST" class="form-control" action="{{ url('/barang/update', $data->id) }}">
                        {{ csrf_field() }}
                        <div class="mb-3">
                          <label for="validationTextarea" class="form-label">Nama Barang</label>
                          <input name="txt_barang" type="text" value="{{$data->nama_barang}}" class="form-control @error('txt_barang')is-invalid @enderror" id="txt_barang" placeholder="Nama Barang">
                            @error('txt_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="validationTextarea" class="form-label">Kategori Barang</label>
                            <select name="txt_kategori_barang" class="form-control @error('txt_kategori_barang')is-invalid @enderror" id="_kategori_barang">
                                <option value="" selected disabled>Kategori Barang</option>
                                @foreach($kategori as $k)
                                    <option value="{{$k->id}}" {{ $data->jenis_barang_id == $k->id ? 'selected' : '' }}>{{$k->kategori_barang}}</option>
                                @endforeach
                            </select>
                            @error('txt_kategori_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                          <label for="validationTextarea" class="form-label">Harga Barang</label>
                          <input name="txt_harga" type="text" value="{{$data->harga}}" class="form-control @error('txt_harga')is-invalid @enderror" id="txt_harga" placeholder="Harga Barang">
                             @error('txt_harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                          <label for="validationTextarea" class="form-label">Stok</label>
                          <input name="txt_stok" type="text" value="{{$data->stok}}" class="form-control @error('txt_stok')is-invalid @enderror" id="txt_stok" placeholder="Stok Barang">
                            @error('txt_stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
    </div>

@include('partials.footer')

<script type="text/javascript">
    $(document).ready(function() {
        $('#_kategori_barang').select2();
    });
</script>

@endsection
