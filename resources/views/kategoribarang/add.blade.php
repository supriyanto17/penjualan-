@php
$title='Kategori Barang';
@endphp

@extends('layouts.main')
@section('content')



    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                  <h4>Tambah Data Kategori Barang</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{route('/kategori-barang')}}" class="btn btn-secondary">Kembali</a>
                    </div>
                    <form class="form-control" action="{{route('/kategori-barang/tambah-data/save')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                          <label for="validationTextarea" class="form-label">Kategori Barang</label>
                          <input name="txt_kategori" type="text" value="{{old('txt_kategori')}}" class="form-control @error('txt_kategori')is-invalid @enderror" id="txt_kategori" placeholder="Kategori Barang">
                            @error('txt_kategori')
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
