@php
$title='Kategori Barang';
@endphp

@extends('layouts.main')
@section('content')

    {{-- <div class="container"> --}}
        <div class="row" >
          <div class="col-4">
            <div class="card mt-4">
                <div class="card-header">
                  <h4>Cari Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-cari-barang" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            @php
                                $i=1;
                            @endphp
                            <tbody>
                                @foreach ($caribarang as $cb)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$cb['nama_barang']}}</td>
                                        <td>{{$cb['harga']}}</td>
                                        <td>
                                            <a href="{{url('/transaksi/add-barang', $cb->id)}}" class="btn btn-success">Tambah</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>

          <div class="col-8">
            <div class="card mt-4">
                <div class="card-header">
                  <h4>Transaksi</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p>{{ session('success') }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="table-kasir" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th width="2%;">Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                                </tr>
                            </thead>
                            @php
                                $no=1;
                            @endphp
                            <tbody>
                                @foreach ($transaksibarang as $tb)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$tb['nama_barang']}}</td>
                                        <td>
                                            <input type="number" value="{{$tb['kuantiti']}}" class="txt_kuantiti form-control" name="txt_kuantiti" id="txt_kuantiti" readonly>
                                        </td>
                                        <td><input type="number" value={{$tb['total']}} class="form-control" name="txt_total" id="txt_total" readonly></td>
                                        <td>
                                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$tb['KeranjangID']}}" data-original-title="Update" class="edit btn btn-warning updateBarang">Update</a>
                                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$tb['KeranjangID']}}" data-original-title="Delete" class="btn btn-danger deleteBarang">X</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <form class="form-control mb-2" action="{{route('/transaksi/bayar-barang/store')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="txt_tanggal" id="txt_tanggal" value="{{$tanggal}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">No. Transaksi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="txt_notransaksi" id="txt_notransaksi" value="{{$kodetrans}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Grand Total</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" value={{$grand_total}} name="txt_grand_total" id="txt_grand_total" placeholder="Grand Total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Bayar</label>
                                    <div class="col-sm-8">
                                        <input type="number" value="{{old('txt_bayar')}}" class="form-control txt_bayar @error('txt_bayar')is-invalid @enderror" name="txt_bayar" id="txt_bayar" placeholder="Nominal Bayar">
                                        @error('txt_bayar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-12 text-end">
                                <button type="submit" class="btn btn-primary">Bayar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>

    {{-- MODAL --}}
        <form id="formUpdateBarang">
            {{csrf_field()}}
            <div class="modal modalUpdateBarang" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row mb-3">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Nama Barang</label>
                                <div class="col-sm-8">
                                    <input type="hidden" class="form-control" name="txt_id_keranjang" id="txt_id_keranjang" readonly>
                                    <input type="text" class="form-control" name="txt_nama_barang" id="txt_nama_barang" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Harga Barang</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="txt_harga_barang" id="txt_harga_barang" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Beli Barang</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="txt_jumlah_belibarang" id="txt_jumlah_belibarang">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Total</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="txt_total_belibarang" id="txt_total_belibarang" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    {{-- MODAL --}}

@include('partials.footer')

<script type="text/javascript">
    $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $('#table-cari-barang').DataTable({
        "processing": true,
        "dom":
            "<'row'<'col-sm-12 col-md-12'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-12'p>>",
        "renderer": 'bootstrap'
      });

    var table = $('#table-kasir').DataTable({
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

    $('body').on('click', '.updateBarang', function () {
        $('.modalUpdateBarang').modal('show');
        var keranjang_id = $(this).data('id');
        $.ajax({
            data: {
                'id' : keranjang_id
            },
            url: "{{ url('/transaksi/update-barang') }}" + "/" + keranjang_id,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                // console.log(data);
                $('#txt_id_keranjang').val(data.id);
                $('#txt_nama_barang').val(data.nm_barang);
                $('#txt_harga_barang').val(data.harga_barang);
                $('#txt_jumlah_belibarang').val(data.kuantiti);
                $('#txt_total_belibarang').val(data.total);
            }
        });
    });

    $('#formUpdateBarang').on('submit', function(e){
      e.preventDefault();
      $.ajax({
        data: $('#formUpdateBarang').serialize(),
        url: "{{ route('/transaksi/update-barang/store') }}",
        type: "POST",
        dataType: 'json',
        success: function (data) {
            window.location.reload();
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
  });

  $('body').on('click', '.deleteBarang', function () {
      var keranjang_id = $(this).data("id");
      Swal.fire({
        title: 'Yakin Hapus Data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Tidak'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
              type: "GET",
              url: "{{url('/transaksi/delete-barang')}}"+'/'+keranjang_id,
              success: function (data) {
                window.location.reload();
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
      })
  });

    $(".txt_bayar").blur(function() {
        var Bayar = parseFloat($(".txt_bayar").val());
        var Total = parseFloat($("#txt_grand_total").val());
        if(Bayar < Total){
            alert('Mohon maaf nominal kurang');
            $("#txt_bayar").val('');
        }
    });

});


  </script>

@endsection
