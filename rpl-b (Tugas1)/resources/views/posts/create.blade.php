<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman tambah data post</title>
</head>
<body>
    <h1>judul</h1>

    <form action="{{route('posts.store')}}" method ="POST">
        @csrf
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="title">

        <label for="konten">Judul</label>
        <input type="text" id="konten" name="content">
        <button type="submit">simpan</button>
    </form>
</body>
</html>