@php
$title='penjualan';
@endphp

@extends('layouts.main')
@section('content')

    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                  <h4>Data Penjualan</h4>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                    </div>
                    <div class="table-responsive">                        
                        <table id="table-home" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                                <th>Jumlah Terjual</th>
                                <th>Tanggal Transaksi</th>
                                <th>Jenis Barang</th>
                                </tr>
                            </thead>
                            @php
                                $i=1;
                            @endphp
                            <tbody>
                                @foreach ($data as $d)
                              <tr>
                                <td>{{$i++}}.</td>
                                <td>{{$d['nama_barang']}}</td>
                                <td>{{$d['stok']}}</td>
                                <td>{{$d['kuantiti']}}</td>
                                @php
                                    $originalDate  = $d['tanggal'];
                                    $newDate = date("Y-m-d", strtotime($originalDate));
                                @endphp
                                <td>{{$newDate}}</td>
                                <td>{{$d['kategori_barang']}}</td>
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

    var minDate, maxDate;
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date( data[4] );

            console.log(min);
            console.log(max);
            console.log(date);
            if (
                ( min === null && max === null ) ||
                ( min === null && date <= max ) ||
                ( min <= date   && max === null ) ||
                ( min <= date   && date <= max )
            ) {
                return true;
            }
            return false;
        }
    );

    $(document).ready(function() {
        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'MMMM Do YYYY'
        });

        // DataTables initialisation
        var table = $('#table-home').DataTable();

        // Refilter the table
        $('#min, #max').on('change', function () {
            table.draw();
        });
    });

    $(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    // $('#table-home').DataTable({
    //     "lengthMenu": [
    //         [10, 25, 50, -1],
    //         [10, 25, 50, 'All'],
    //     ],
    //     "processing": true,
    //     "buttons": [
    //       {extend: 'excel', text:'<i class="fas fa-file-excel"></i> Excel', className: 'btn-primary'},
    //       {extend: 'csv', text:'<i class="fas fa-file-csv"></i> Csv', className: 'btn-primary'},
    //       {extend: 'pdf', text:'<i class="fas fa-file-pdf"></i> Pdf', className: 'btn-primary'},
    //     ],
    //     "dom":
    //         "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
    //         "<'row'<'col-sm-12'tr>>" +
    //         "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    //     "renderer": 'bootstrap'
    // });


  });
  </script>

@endsection
