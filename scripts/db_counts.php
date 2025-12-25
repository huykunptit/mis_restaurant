<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = ['users','categories','menus','menu_options','tables','temporary_orders','transactions','reservations','invoices','invoice_details'];
foreach ($tables as $t) {
    $count = Illuminate\Support\Facades\DB::table($t)->count();
    echo "$t: $count\n";
}
