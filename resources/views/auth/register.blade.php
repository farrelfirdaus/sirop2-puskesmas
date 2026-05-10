<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — SIROP</title>
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 font-weight-bold">Daftar Akun Pasien</h1>
                            <p class="text-muted">Sistem Informasi Rekam Online Puskesmas</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name') }}" placeholder="Nama lengkap" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email') }}" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Password (min. 6 karakter)" required>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Ulangi password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Daftar Sekarang</button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a href="{{ route('login') }}">Sudah punya akun? Login di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>