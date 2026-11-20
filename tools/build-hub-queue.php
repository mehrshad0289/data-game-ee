<?php

/**
 * Rebuilds hub-queue/*.json from games-completed folders and hub-meta/fazer-platforms.tsv.
 * Does not touch hub-claimed or hub-copy. Steam rows are omitted.
 */
$root = dirname(__DIR__);
$gamesDir = $root.DIRECTORY_SEPARATOR.'games-completed';
$queueDir = $root.DIRECTORY_SEPARATOR.'hub-queue';
$tsv = $root.DIRECTORY_SEPARATOR.'hub-meta'.DIRECTORY_SEPARATOR.'fazer-platforms.tsv';

if (! is_dir($queueDir) && ! mkdir($queueDir, 0777, true) && ! is_dir($queueDir)) {
    fwrite(STDERR, "cannot create hub-queue\n");
    exit(1);
}

$games = [];
foreach (scandir($gamesDir) ?: [] as $folder) {
    if ($folder === '.' || $folder === '..') {
        continue;
    }
    if (! is_dir($gamesDir.DIRECTORY_SEPARATOR.$folder)) {
        continue;
    }
    $key = preg_replace('/^\d+-/', '', $folder) ?? $folder;
    if (isSteam($key) || isSteam($folder)) {
        continue;
    }
    $games[$key] = $folder;
}

$fazer = [];
foreach (file($tsv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
    $line = trim($line);
    if ($line === '' || str_starts_with($line, '#')) {
        continue;
    }
    [$platform, $ft] = array_pad(preg_split("/\t+/", $line) ?: [], 2, '');
    $platform = strtolower(trim((string) $platform));
    $ft = strtolower(trim((string) $ft));
    if ($platform === '' || isSteam($platform) || isSteam($ft)) {
        continue;
    }
    $fazer[$platform][$ft] = true;
}

$written = 0;
foreach ($games as $key => $folder) {
    $types = array_keys($fazer[$key] ?? []);
    sort($types);
    writeQueue($queueDir, $folder, titleFromKey($key), 'games-completed', $types, $folder);
    $written++;
    unset($fazer[$key]);
}

$extra = 0;
foreach ($fazer as $platform => $types) {
    $list = array_keys($types);
    sort($list);
    writeQueue($queueDir, $platform, titleFromKey($platform), 'fazer', $list, null);
    $extra++;
}

echo "games={$written} fazer_only={$extra} queue=".($written + $extra)."\n";

function isSteam(string $value): bool
{
    $value = strtolower($value);

    return $value === 'steam' || str_contains($value, 'steam');
}

function titleFromKey(string $key): string
{
    $labels = [
        'itunes' => 'iTunes',
        'lol' => 'League of Legends',
    ];
    if (isset($labels[$key])) {
        return $labels[$key];
    }
    $acronyms = [
        'pubg' => 'PUBG',
        'ea' => 'EA',
        'fc' => 'FC',
        'cod' => 'CoD',
        'nba' => 'NBA',
        'psn' => 'PSN',
        'afk' => 'AFK',
        'rpg' => 'RPG',
        'mmo' => 'MMO',
        'vr' => 'VR',
        'usdt' => 'USDT',
        'qq' => 'QQ',
    ];
    $small = ['of' => true, 'and' => true, 'the' => true, 'a' => true, 'vs' => true];
    $parts = array_values(array_filter(explode('-', $key), fn (string $part): bool => $part !== ''));
    $words = [];
    foreach ($parts as $index => $part) {
        if (isset($acronyms[$part])) {
            $words[] = $acronyms[$part];
            continue;
        }
        if ($index > 0 && isset($small[$part])) {
            $words[] = $part;
            continue;
        }
        $words[] = ucfirst($part);
    }

    return implode(' ', $words);
}

/**
 * @param  list<string>  $types
 */
function writeQueue(string $dir, string $slug, string $name, string $source, array $types, ?string $folder): void
{
    $payload = [
        'slug' => $slug,
        'name' => $name,
        'source' => $source,
        'fazerTypes' => $types,
    ];
    if ($folder !== null) {
        $payload['workbook'] = 'games-completed/'.$folder.'/'.$folder.'.xlsx';
    }
    $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($dir.DIRECTORY_SEPARATOR.$slug.'.json', $json."\n");
}
