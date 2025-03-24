@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h2>

        <div class="row">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-muted mb-0">Pasien Hari Ini</h5>
                                <p class="card-text fs-2 fw-bold">{{ $todayPatients }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="bi bi-clipboard2-pulse"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-muted mb-0">Pemeriksaan Hari Ini</h5>
                                <p class="card-text fs-2 fw-bold">{{ $todayExaminations }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="bi bi-capsule"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-muted mb-0">Resep Hari Ini</h5>
                                <p class="card-text fs-2 fw-bold">{{ $todayPrescriptions }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title text-muted mb-0">Pendapatan Hari Ini</h5>
                                <p class="card-text fs-2 fw-bold">Rp {{ number_format($todayIncome, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bi bi-hourglass-split me-2"></i>
                        <h5 class="mb-0">Antrian Menunggu</h5>
                    </div>
                    <div class="card-body">
                        @if ($waitingQueues->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th><i class="bi bi-123"></i> No. Antrian</th>
                                            <th><i class="bi bi-person"></i> Nama Pasien</th>
                                            <th><i class="bi bi-activity"></i> Layanan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($waitingQueues as $queue)
                                            <tr>
                                                <td>{{ $queue->queue_number }}</td>
                                                <td>{{ $queue->patient->name }}</td>
                                                <td><span class="badge bg-primary">{{ $queue->service_type }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox text-muted fs-1"></i>
                                <p class="text-muted mt-2">Tidak ada antrian menunggu.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bi bi-clipboard2-pulse me-2"></i>
                        <h5 class="mb-0">Sedang Diperiksa</h5>
                    </div>
                    <div class="card-body">
                        @if ($inProgressQueues->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th><i class="bi bi-123"></i> No. Antrian</th>
                                            <th><i class="bi bi-person"></i> Nama Pasien</th>
                                            <th><i class="bi bi-person-vcard"></i> Dokter</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inProgressQueues as $queue)
                                            <tr>
                                                <td>{{ $queue->queue_number }}</td>
                                                <td>{{ $queue->patient->name }}</td>
                                                <td>{{ $queue->doctor->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-clipboard-x text-muted fs-1"></i>
                                <p class="text-muted mt-2">Tidak ada pasien yang sedang diperiksa.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="bi bi-graph-up me-2"></i>
                        <h5 class="mb-0">Grafik Kunjungan 7 Hari Terakhir</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="visitsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background-color: var(--primary);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .table th {
            font-weight: 600;
        }

        .badge {
            padding: 8px 12px;
            font-weight: 500;
        }
    </style>
@endsection

@section('scripts')
    <script>
        var ctx = document.getElementById('visitsChart').getContext('2d');
        var visitsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($last7Days) !!},
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: {!! json_encode($dailyPatients) !!},
                    backgroundColor: 'rgba(255, 107, 159, 0.2)',
                    borderColor: '#ff6b9f',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: '#ff6b9f'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                family: "'Segoe UI', sans-serif",
                                weight: '500'
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
