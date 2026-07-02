<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$destinations = App\Models\Destination::all();
foreach($destinations as $d) {
    echo $d->name . ' - Stock: ' . $d->total_stock . ' - Avail: ' . $d->getAvailableStock('2026-07-02') . PHP_EOL;
}
