<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}!</p>
        <p>Role: {{ auth()->user()->role }}</p>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5>Categories</h5>
                        <p>{{ \App\Models\Category::count() }} items</p>
                        <a href="/admin/kategori" class="btn btn-primary">Manage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>