<?php

$root = dirname(__DIR__);
$queue = jsonFiles($root.DIRECTORY_SEPARATOR.'hub-queue');
$claimed = jsonFiles($root.DIRECTORY_SEPARATOR.'hub-claimed');
$done = [];
$copy = $root.DIRECTORY_SEPARATOR.'hub-copy';
foreach (scandir($copy) ?: [] as $name) {
    if ($name === '.' || $name === '..' || $name === '.gitkeep') {
        continue;
    }
    $path = $copy.DIRECTORY_SEPARATOR.$name;
    if (! is_dir($path)) {
        continue;
    }
    if (! is_file($root.DIRECTORY_SEPARATOR.'hub-queue'.DIRECTORY_SEPARATOR.$name.'.json')) {
        $done[] = $name;
    }
}

$remaining = count($queue);
$working = count($claimed);
$finished = count($done);
$total = $remaining + $finished;
$utc = gmdate('Y-m-d H:i:s').' UTC';
$lines = [
    '# پیشرفت جمع‌آوری سوال و توضیح هاب',
    '',
    'مرجع: GitHub `main` — https://github.com/mehrshad0289/data-game-ee',
    '',
    'آخرین شمارش: '.$utc,
    '',
    '| وضعیت | عدد |',
    '|---|---|',
    '| باقی در صف (`hub-queue`) | '.$remaining.' |',
    '| در حال کار (`hub-claimed`) | '.$working.' |',
    '| تمام‌شده (`hub-copy` و دیگر در صف نیست) | '.$finished.' |',
    '| جمع | '.$total.' |',
    '',
    'استیم در صف نیست. تمام‌شدن یک محصول یعنی فایلش از `hub-queue` حذف شده و پوشه‌اش در `hub-copy` مانده است.',
    '',
];
file_put_contents($root.DIRECTORY_SEPARATOR.'PROGRESS.md', implode("\n", $lines));
echo "remaining={$remaining} claimed={$working} done={$finished} total={$total}\n";

/**
 * @return list<string>
 */
function jsonFiles(string $dir): array
{
    $out = [];
    foreach (scandir($dir) ?: [] as $name) {
        if (! str_ends_with($name, '.json')) {
            continue;
        }
        $out[] = $name;
    }

    return $out;
}
