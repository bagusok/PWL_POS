@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button type="button" onclick="modalAction('{{ url('stock/create_ajax') }}')"
                    class="btn btn-sm btn-primary mt-1">Tambah</button>
            </div>
        </div>
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    {{ session('error') }}
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover table-sm" id="table_stock">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Barang</th>
                        <th>Supplier</th>
                        <th>Penginput</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        console.log('Document ready');

        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataStock;

        $(document).ready(function() {
            dataStock = $('#table_stock').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('stock/list') }}",
                    "dataType": "json",
                    "type": "POST",

                },
                columns: [{
                        // nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "stock_id",
                        className: "",
                        // orderable: true, jika ingin kolom ini bisa diurutkan
                        orderable: true,
                        // searchable: true, jika ingin kolom ini bisa dicari
                        searchable: true
                    }, {
                        data: "barang.barang_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "supplier.supplier_nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "user.username",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "stock_jumlah",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "stock_tanggal",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });



        });
    </script>
@endpush
