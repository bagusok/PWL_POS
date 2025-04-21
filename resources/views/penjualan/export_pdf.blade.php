<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
            color: #333;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .header {
            display: flex;
            align-items: center;
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 2px solid #004d99;
        }

        .logo {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 15%;
        }

        .logo img {
            width: auto;
            height: 90px;
            max-width: 150px;
        }

        .header-text {
            width: 100%;
            text-align: center;
        }

        .ministry {
            font-size: 11pt;
            font-weight: 500;
            margin-bottom: 5px;
            color: #004d99;
        }

        .institution {
            font-size: 16pt;
            font-weight: 700;
            margin-bottom: 8px;
            color: #002a5c;
        }

        .address {
            font-size: 9pt;
            margin-bottom: 2px;
            color: #555;
        }

        h3.report-title {
            text-align: center;
            font-size: 18pt;
            color: #002a5c;
            margin: 25px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        h3.report-title:after {
            content: '';
            display: block;
            width: 100px;
            height: 3px;
            background-color: #f5a623;
            margin: 10px auto 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .data-table th {
            background-color: #004d99;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
            font-size: 11pt;
        }

        .data-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10pt;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .data-table tbody tr:hover {
            background-color: #f0f7ff;
        }

        .inner-table {
            width: 100%;
            font-size: 9pt;
            border-collapse: collapse;
        }

        .inner-table th {
            background-color: #e6f0ff;
            color: #004d99;
            padding: 6px 8px;
            text-align: left;
            font-weight: 500;
            border-bottom: 1px solid #c0d6f0;
        }

        .inner-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-price {
            font-weight: 700;
            color: #004d99;
        }

        .date-cell {
            color: #666;
            font-style: italic;
        }

        .sales-code {
            font-family: monospace;
            font-weight: 500;
            color: #004d99;
        }

        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
        }

        .footer-section {
            width: 30%;
            text-align: center;
            font-size: 9pt;
        }

        .signature-line {
            margin: 60px 0 8px;
            border-top: 1px solid #555;
            width: 70%;
            display: inline-block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-text">
                <div class="ministry">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                <div class="institution">POLITEKNIK NEGERI MALANG</div>
                <div class="address">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                <div class="address">Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420</div>
                <div class="address">Laman: www.polinema.ac.id</div>
            </div>
        </div>

        <h3 class="report-title">Laporan Data Penjualan</h3>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th width="12%">Kode Penjualan</th>
                    <th width="15%">Pembeli</th>
                    <th width="12%">Penginput</th>
                    <th width="33%">Barang</th>
                    <th width="12%">Total Harga</th>
                    <th width="11%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="sales-code">{{ $d->penjualan_kode }}</td>
                        <td>{{ $d->pembeli }}</td>
                        <td>{{ $d->user->username }}</td>
                        <td>
                            <table class="inner-table">
                                <thead>
                                    <tr>
                                        <th width="45%">Barang</th>
                                        <th width="15%" class="text-center">Jumlah</th>
                                        <th width="20%" class="text-right">Harga</th>
                                        <th width="20%" class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($d->penjualan_detail as $pd)
                                        @php
                                            $totalPerBarang = $pd->jumlah * $pd->harga;
                                        @endphp
                                        <tr>
                                            <td>{{ $pd->barang->barang_nama }}</td>
                                            <td class="text-center">{{ $pd->jumlah }}</td>
                                            <td class="text-right">{{ number_format($pd->harga, 0, ',', '.') }}</td>
                                            <td class="text-right">{{ number_format($totalPerBarang, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td class="total-price text-right">
                            {{ 'Rp ' . number_format($d->penjualan_detail_sum_harga, 0, ',', '.') }}</td>
                        <td class="date-cell">{{ $d->penjualan_tanggal }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
