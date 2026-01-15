<!DOCTYPE html>
<html>
<head>
    <title>Edit Kategori - Simple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Kategori</h1>
        
        <form action="{{ route('admin.kategori.update', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama" class="form-control" value="{{ $category->nama }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Thumbnail (Optional)</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                @if($category->thumbnail)
                    <div class="mt-2">
                        <img src="{{ asset('storage/categories/' . $category->thumbnail) }}" 
                             alt="{{ $category->nama }}" style="max-width: 100px;">
                    </div>
                @endif
            </div>
            
            <button type="submit" class="btn btn-success">Update</button>
            <a href="/admin/kategori" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>