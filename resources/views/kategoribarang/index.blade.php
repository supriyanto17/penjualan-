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
                  <h4>Data Kategori Barang</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p>{{ session('success') }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{route('/kategori-barang/tambah-data')}}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="table-responsive">
                        <table id="table-barang" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Kategori Barang</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            @php
                                $i=1;
                            @endphp
                            <tbody>
                                @foreach ($data as $d)
                              <tr>
                                <td>{{$i++}}.</td>
                                <td>{{$d['kategori_barang']}}</td>
                                <td>
                                    <a href="{{url('/kategori-barang/edit', $d->id)}}" class="btn btn-secondary">Edit</a>
                                    <form action="{{url('/kategori-barang/delete', $d->id)}}" method="post" class="d-inline border-0">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Yakin Hapus Data?')">Hapus</button>
                                    </form>
                                    {{-- <button type="button" class="btn btn-danger">Hapus</button> --}}
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>

@include('partials.footer')

<script type="text/javascript">
    $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    $('#table-barang').DataTable({
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "processing": true,
        "buttons": [
          {extend: 'excel', text:'<i class="fas fa-file-excel"></i> Excel', className: 'btn-primary'},
          {extend: 'csv', text:'<i class="fas fa-file-csv"></i> Csv', className: 'btn-primary'},
          {extend: 'pdf', text:'<i class="fas fa-file-pdf"></i> Pdf', className: 'btn-primary'},
        ],
        "dom":
            "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "renderer": 'bootstrap'
    });


  });
  </script>

@endsection
