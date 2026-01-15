<!DOCTYPE html>
<html>
<head>
    <title>Test Kategori</title>
</head>
<body>
    <h1>Test Kategori Page</h1>
    <p>Jumlah kategori: {{ $categories->count() }}</p>
    
    @if($categories->count() > 0)
        <ul>
        @foreach($categories as $category)
            <li>{{ $category->nama }}</li>
        @endforeach
        </ul>
    @else
        <p>Tidak ada kategori</p>
    @endif
</body>
</html>