<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$all = App\Models\DataSource::all();
foreach ($all as $ds) {
    echo "ID: {$ds->id} | Key: {$ds->key}\n";
    echo "  Name: {$ds->name}\n";
    echo "  Source Type: {$ds->source_type}\n";
    echo "  File Path: {$ds->file_path}\n";
    echo "  URL: {$ds->url}\n";
    echo "  Effective URL: {$ds->effective_url}\n";
    echo "----------------------------------------\n";
}
