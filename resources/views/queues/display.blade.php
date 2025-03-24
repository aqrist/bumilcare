<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="30">
    <title>Display Antrian - Klinik Kehamilan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #ff6b9f;
            --primary-dark: #d84a7b;
            --secondary: #4a90c8;
            --dark: #333333;
            --light: #f8f9fa;
        }

        body {
            background-color: var(--light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            background-color: var(--primary);
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .queue-number {
            font-size: 7rem;
            font-weight: bold;
            color: var(--primary);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .current-queue {
            padding: 30px;
            background-color: white;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .current-queue:hover {
            transform: translateY(-5px);
        }

        .queue-list {
            font-size: 2rem;
        }

        .time {
            font-size: 2.5rem;
            color: var(--primary);
            margin-top: 30px;
            font-weight: 600;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: var(--primary);
            color: white;
            padding: 15px 0;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.1);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 100%;
        }

        .card-header {
            padding: 20px;
            border: none;
        }

        .card-header.bg-primary {
            background-color: var(--primary) !important;
        }

        .card-header.bg-success {
            background-color: var(--primary-dark) !important;
        }

        .badge.bg-success {
            background-color: var(--primary) !important;
            padding: 15px 30px;
            font-size: 2rem;
            border-radius: 10px;
            margin: 10px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .doctor-name {
            font-size: 1.5rem;
            color: var(--primary-dark);
            margin-top: 15px;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .current-queue.active {
            animation: pulse 2s infinite;
        }
    </style>
</head>

<body>
    <div class="header text-center">
        <h1><i class="bi bi-heart-pulse-fill"></i> KLINIK KEHAMILAN</h1>
        <h3>SISTEM INFORMASI ANTRIAN</h3>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center">SEDANG DILAYANI</h3>
                    </div>
                    <div class="card-body text-center">
                        @if ($inProgressQueues->count() > 0)
                            @foreach ($inProgressQueues as $queue)
                                <div class="current-queue mb-2">
                                    <h5>NOMOR ANTRIAN</h5>
                                    <div class="queue-number">{{ substr($queue->queue_number, -3) }}
                                    </div>
                                    @if ($queue->doctor)
                                        <p class="mt-3 mb-0">Dokter: {{ $queue->doctor->name }}</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="current-queue">
                                <h5>TIDAK ADA ANTRIAN</h5>
                                <div class="queue-number">---</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h3 class="text-center">ANTRIAN BERIKUTNYA</h3>
                    </div>
                    <div class="card-body">
                        @if ($waitingQueues->count() > 0)
                            <div class="queue-list">
                                @foreach ($waitingQueues->take(5) as $queue)
                                    <div class="d-flex justify-content-center mb-2">
                                        <span
                                            class="badge bg-success fs-4">{{ substr($queue->queue_number, -3) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center">
                                <h5>TIDAK ADA ANTRIAN</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="time text-center mt-4">
            <div id="current-time"></div>
        </div>
    </div>

    <div class="footer text-center">
        <p class="mb-0">© {{ date('Y') }} Klinik Kehamilan - Sistem Informasi Antrian</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>
</body>

</html>
