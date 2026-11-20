<?php

$root = dirname(__DIR__);
$queueDir = $root.DIRECTORY_SEPARATOR.'hub-queue';
$claimedDir = $root.DIRECTORY_SEPARATOR.'hub-claimed';
$want = 2;
$free = [];
$claimed = [];
foreach (scandir($claimedDir) ?: [] as $name) {
    if (str_ends_with($name, '.json')) {
        $claimed[$name] = true;
    }
}
foreach (scandir($queueDir) ?: [] as $name) {
    if (! str_ends_with($name, '.json')) {
        continue;
    }
    if (isset($claimed[$name])) {
        continue;
    }
    $slug = substr($name, 0, -5);
    if (str_contains(strtolower($slug), 'steam')) {
        continue;
    }
    $free[] = $name;
}
if ($free === []) {
    fwrite(STDERR, "queue empty\n");
    exit(1);
}
$pick = [];
$n = count($free);
$take = min($want, $n);
for ($i = 0; $i < $take; $i++) {
    $index = random_int(0, $n - 1);
    $pick[] = $free[$index];
    $free[$index] = $free[$n - 1];
    $n--;
}
$host = gethostname() ?: 'worker';
$when = gmdate('c');
foreach ($pick as $name) {
    $src = $queueDir.DIRECTORY_SEPARATOR.$name;
    $raw = file_get_contents($src);
    $data = is_string($raw) ? json_decode($raw, true) : null;
    if (! is_array($data)) {
        $data = ['slug' => substr($name, 0, -5)];
    }
    $data['claimedAt'] = $when;
    $data['claimedBy'] = $host;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($claimedDir.DIRECTORY_SEPARATOR.$name, $json."\n");
    echo substr($name, 0, -5).PHP_EOL;
}
