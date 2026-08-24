<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Admin Dinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow p-4" style="width: 350px;">
        <h4 class="text-center fw-bold mb-4">Login Admin</h4>
        
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.proses_login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Akses</label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: admin@sukun.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-bold">Masuk</button>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 mt-2">Ke Form Utama</a>
        </form>
    </div>
</body>
</html>