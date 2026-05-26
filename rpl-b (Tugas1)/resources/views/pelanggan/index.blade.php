<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/pelanggan_create.css">
</head>
<body>
    <h1>Halaman Utama</h1>

    <table border="1">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Pelanggan</td>
                <td>Alamat</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggan as $orang)

            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$orang->nama_pelanggan}}</td>
                <td>{{$orang->alamat}}</td>
        
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>