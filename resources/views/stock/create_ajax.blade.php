<form action="{{ url('/stock/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Barang</label>
                    <select id="select-barang" name="barang_id" id="barang_id" class="form-control" required>
                        <option value="">- Pilih Barang -</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }} ({{ $b->barang_kode }})</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Supplier</label>
                    <select id="select-supplier" name="supplier_id" id="supplier_id" class="form-control" required>
                        <option value="">- Pilih Supplier -</option>
                        @foreach ($supplier as $s)
                            <option value="{{ $s->supplier_id }}">{{ $s->supplier_nama }} ({{ $s->supplier_kode }})
                            </option>
                        @endforeach
                    </select>
                    <small id="error-supplier_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input value="" type="number" name="stock_jumlah" id="stock_jumlah" class="form-control"
                        placeholder="1000" required min="1">
                    <small id="error-stock_jumlah" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                    <input value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" type="date" name="stock_tanggal"
                        id="stock_tanggal" class="form-control" placeholder="2023-01-01" required>
                    <small id="error-stock_tanggal" class="error-text form-text text-danger"></small>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {

        $('#myModal').on('shown.bs.modal', function() {
            $('#select-barang').select2({
                placeholder: 'Pilih Barang',
                theme: 'bootstrap-5',
                dropdownParent: $('#myModal')
            });

            $('#select-supplier').select2({
                placeholder: 'Pilih Supplier',
                theme: 'bootstrap-5',
                dropdownParent: $('#myModal')
            });
        });

        $("#form-tambah").validate({
            rules: {
                barang_id: {
                    required: true,
                },
                supplier_id: {
                    required: true,
                },
                stock_jumlah: {
                    required: true,
                    number: true,
                },
                stock_tanggal: {
                    required: true,
                    date: true,
                }
            },
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
                            dataStock.ajax.reload();
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
