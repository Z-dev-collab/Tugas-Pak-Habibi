<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Halaman Utama</h1>

    <table border="1">
        <thead>
            <tr>
                <td>No</td>
                <td>Judul</td>
                <td>Konten</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)

            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->content}}</td>
        
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>