<?php
$dir = __DIR__ . '/app/Models';
foreach (glob($dir . '/*.php') as $file) {
    if (basename($file) === 'ActivityLog.php' || basename($file) === 'User.php') continue;
    $content = file_get_contents($file);
    if (!str_contains($content, 'use App\Traits\LogsActivity;')) {
        $content = str_replace("use Illuminate\Database\Eloquent\Model;", "use Illuminate\Database\Eloquent\Model;\nuse App\Traits\LogsActivity;", $content);
        if (str_contains($content, 'use HasFactory;')) {
            $content = str_replace('use HasFactory;', 'use HasFactory, LogsActivity;', $content);
        } else {
            $content = preg_replace('/class\s+[^{]+\s*\{/', "$0\n    use LogsActivity;\n", $content);
        }
        file_put_contents($file, $content);
        echo "Updated " . basename($file) . "\n";
    }
}
