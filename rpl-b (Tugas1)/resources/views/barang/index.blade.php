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
                <td>Nama Barang</td>
                <td>Varian</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang as $baran)

            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$baran->nama_barang}}</td>
                <td>{{$baran->varian}}</td>
        
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>