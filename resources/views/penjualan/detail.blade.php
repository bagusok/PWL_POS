@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Penjualan Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">

                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-left col-3">ID</th>
                            <td class="col-9">{{ $penjualan->penjualan_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-left col-3">Kode</th>
                            <td class="col-9">{{ $penjualan->penjualan_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-left col-3">Pembeli</th>
                            <td class="col-9">{{ $penjualan->pembeli }}</td>
                        </tr>
                        <tr>
                            <th class="text-left col-3">Tanggal</th>
                            <td class="col-9">{{ $penjualan->penjualan_tanggal }}</td>
                        </tr>
                    </table>
                    <table class="table table-sm table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_bayar = 0; @endphp

                            @foreach ($penjualan->penjualan_detail as $item)
                                <tr>
                                    <td>{{ $item->barang->barang_nama }}</td>
                                    <td>{{ 'Rp ' . number_format($item->barang->harga_jual, 0, ',', '.') }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>{{ 'Rp ' . number_format($item->jumlah * $item->barang->harga_jual, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @php $total_bayar += $item->jumlah * $item->barang->harga_jual; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Total Semua Harga --}}
                    <div class="row mb-4">
                        <div class="col-12 text-right">
                            <strong>Total Bayar :</strong>
                            {{ 'Rp ' . number_format($total_bayar, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataPenjualan.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
