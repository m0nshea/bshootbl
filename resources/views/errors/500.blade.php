<!DOCTYPE html>
<html>
<head>
    <title>Server Error</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .error-container { max-width: 600px; margin: 0 auto; }
        .error-title { color: #dc3545; font-size: 24px; margin-bottom: 20px; }
        .error-message { background: #f8f9fa; padding: 20px; border-radius: 5px; }
        .back-link { margin-top: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-title">Server Error (500)</h1>
        <div class="error-message">
            <p><strong>Error:</strong> {{ $message ?? 'Terjadi kesalahan internal server.' }}</p>
        </div>
        <div class="back-link">
            <a href="{{ route('customer.meja') }}">&larr; Kembali ke Halaman Meja</a>
        </div>
    </div>
</body>
</html>