<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = ['no_transaksi', 'tanggal', 'nama_kasir', 'total', 'uang_bayar', 'kembalian'];
}
