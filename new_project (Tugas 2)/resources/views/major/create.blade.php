<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman tambah data post</title>
    <style>
        .form-container {
  max-width: 500px;
  width: 100%;
  background: #07c2b2;
  padding: 25px 30px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  margin-bottom: 50px; /* ruang kosong bawah */
}

.form-container h2 {
    font-size: 24px;
    color: #0075c4;
    margin-bottom: 20px;
    border-left: 5px solid #efa00b;
    padding-left: 10px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 6px;
    color: #333;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #0075c4;
    outline: none;
    box-shadow: 0 0 4px rgba(0,117,196,0.3);
}

/* Warna untuk semua label di form */
.form-container label {
    color: #ffffff;          /* biru sesuai sidebar */
    font-weight: 400;        /* sedikit lebih tebal */
    font-size: 14px;         /* ukuran teks */
}

.content {
    margin: 0;
        height: 100vh; /* Full tinggi layar */
        display: flex;
        justify-content: center; /* Horizontal center */
        align-items: center;     /* Vertical center */
        background-color: #f0f0f0;
}

.btn-submit {
    background-color: #0075c4;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
}

.form-container h1{
    text-align: center;
}

    </style>
</head>
<body>
    <div class="content">
        <div class="form-container">
            <h1>Tambah Nama</h1>

            <form action="{{route('major.store')}}" method ="POST">
                @csrf
                <div class="form-group">
                    <label for="kode">Kode</label>
                    <input type="text" id="kode" name="kode">
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama">
                </div>

                <button type="submit" class="btn-submit">simpan</button>
            </form>
        </div>
    </div>
</body>
</html>