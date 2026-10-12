<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register Pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.05);
        }
        h2 {
            color: #198754;
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Form Registrasi Pelanggan</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/pelanggan/register">
        @csrf

        <div class="mb-3">
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="mb-3">
            <input type="date" name="birth_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <input type="text" name="alergi" class="form-control" placeholder="Alergi (opsional)">
        </div>
        <div class="mb-3">
            <input type="text" name="no_wa" class="form-control" placeholder="Nomor WhatsApp" required>
        </div>
        <div class="mb-4">
            <select name="skin_types" class="form-control" required>
                <option value="">-- Pilih Jenis Kulit --</option>
                <option value="berminyak" {{ old('skin_types')=='berminyak' ? 'selected' : '' }}>Berminyak</option>
                <option value="kering" {{ old('skin_types')=='kering' ? 'selected' : '' }}>Kering</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success w-100">Daftar</button>
    </form>

    <div class="text-center mt-3">
        <a href="/pelanggan/login">← Sudah punya akun? Login</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
