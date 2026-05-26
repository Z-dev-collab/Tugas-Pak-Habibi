<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$tables = DB::select('SHOW TABLES');
echo "\n=== DAFTAR TABEL DATABASE ===\n\n";
foreach ($tables as $i => $table) {
    $name = array_values((array)$table)[0];
    echo ($i + 1) . ". " . $name . "\n";

    // Tampilkan kolom setiap tabel
    $columns = DB::select("SHOW COLUMNS FROM `$name`");
    foreach ($columns as $col) {
        echo "   - {$col->Field} ({$col->Type})" . ($col->Null === 'YES' ? ' nullable' : '') . ($col->Key === 'PRI' ? ' [PK]' : '') . ($col->Key === 'UNI' ? ' [UNIQUE]' : '') . "\n";
    }
    echo "\n";
}
