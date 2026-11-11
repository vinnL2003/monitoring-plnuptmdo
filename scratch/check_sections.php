<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Section;

$sections = Section::with(['statCards.dataSource', 'progressItems'])->orderBy('order')->get();
echo "Total Sections: " . $sections->count() . "\n\n";
foreach ($sections as $s) {
    echo "Section #{$s->order} (ID: {$s->id})\n";
    echo "  Slug: {$s->slug}\n";
    echo "  Page: {$s->page}\n";
    echo "  Title: {$s->title}\n";
    echo "  Visible: " . ($s->is_visible ? 'Yes' : 'No') . "\n";
    echo "  StatCards Count: " . $s->statCards->count() . "\n";
    foreach ($s->statCards as $sc) {
        $dsInfo = $sc->dataSource ? "{$sc->dataSource->name} ({$sc->dataSource->key})" : 'None';
        echo "    - Card #{$sc->order}: '{$sc->title}' | Val: '{$sc->value}' | Query: '{$sc->query}' | Sync: " . ($sc->is_auto_sync ? 'Auto' : 'Manual') . " | DS: {$dsInfo}\n";
    }
    echo "  ProgressItems Count: " . $s->progressItems->count() . "\n";
    echo "--------------------------------------------------------\n";
}
