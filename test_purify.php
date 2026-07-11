<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$maliciousHtml = '<a href="javascript:alert(1)">click</a> <span onmouseover="alert(2)">hover</span> <p>safe</p>';
echo "Original: " . $maliciousHtml . "\n";
echo "Purified: " . purify_html($maliciousHtml) . "\n";
