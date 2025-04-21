@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard Penjualan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Sales Today Card -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ 'Rp ' . number_format($todayIncome, 0, ',', '.') }}</h3>
                            <p>Pendapatan Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        {{-- <a href="{{ route('penjualan.index') }}" class="small-box-footer"> --}}
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Total Revenue Today Card -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ 'Rp ' . number_format($monthlyIncome, 0, ',', '.') }}</h3>
                            <p>Pendapatan Bulan Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        {{-- <a href="{{ route('penjualan.index') }}" class="small-box-footer"> --}}
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Monthly Sales Card -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ 'Rp ' . number_format($allIncome, 0, ',', '.') }}</h3>
                            <p>Semua Pendapatan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        {{-- <a href="{{ route('penjualan.index') }}" class="small-box-footer"> --}}
                        Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>


            </div>


        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h3 class="card-title">Grafik Pendapatan Hari Ini</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="todaySalesChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('todaySalesChart').getContext('2d');

        const chartData = {!! json_encode($chartMonthly) !!};

        const labels = chartData.map(item => item.date);
        const data = chartData.map(item => item.total);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan Harian (30 Hari Terakhir)',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.3)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 15
                        }
                    }
                }
            }
        });
    </script>
@endpush
