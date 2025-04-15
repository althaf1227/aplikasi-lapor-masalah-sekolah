<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #00485c;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: #000;
        }
        .card-custom {
            background-color: #d3eaf8;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .btn-warning {
            background-color: #ffa200;
            border: none;
            font-weight: bold;
        }
        .btn-warning:hover {
            background-color: #ff8c00;
        }
        h1 {
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 40px;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #ffffff;
            text-decoration: none;
        }
    </style>
</head>
<body>

<a href="#" class="logout">Logout</a>
<h1 class="text-center">Dashboard Siswa</h1>

<div class="container">
    <div class="row justify-content-center">
        <!-- Profil Siswa -->
        <div class="col-md-5 mb-4">
            <div class="card-custom">
                <h4 class="text-center fw-bold">Profil Siswa</h4>
                <div class="text-center">
                    <img src="https://via.placeholder.com/150" alt="Foto Siswa" class="rounded mb-3" style="width: 150px; height: 180px;">
                </div>
                <p><strong>Nama :</strong> Wijdan Sharfan A</p>
                <p><strong>Kelas :</strong> XII TJKT 3</p>
                <p><strong>Nis :</strong> 18825</p>
                <div class="text-center">
                    <button class="btn btn-warning w-50">Detail</button>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="row">
                <!-- Lapor Masalah -->
                <div class="col-md-12 mb-4">
                    <div class="card-custom">
                        <h4 class="text-center fw-bold">Lapor Masalah</h4>
                        <p>Silahkan ajukan masalah kepada guru BK <br>kapanpun</p>
                        <div class="text-center">
                            <a href="{{ route('chat.guru.list') }}" class="btn btn-warning w-50"> Mulai Chat</a>
                        </div>
                    </div>
                </div>

                <!-- Status Laporan -->
                <div class="col-md-12">
                    <div class="card-custom">
                        <h4 class="text-center fw-bold">Status Laporan</h4>
                        <p><strong>Status Laporan Terakhir :</strong> diproses</p>
                        <p><strong>Jumlah Laporan :</strong> 3</p>
                        <p><strong>Pengumuman :</strong> Tidak ada pengumuman</p>
                        <div class="text-center">
                            <button class="btn btn-warning w-50">Detail riwayat</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
