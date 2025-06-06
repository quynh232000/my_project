<?php
// outto load file | --- created by Mr. Quynh (quynh232000@gmal.com) ---

$values     = [];

foreach (scandir(__DIR__ . '/constants') as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) !== 'php') continue;

    $parts  = explode('_', pathinfo($file, PATHINFO_FILENAME));
    if (count($parts) !== 2) continue;

    [$prefix, $name]        = $parts;
    $values[$prefix][$name] = require __DIR__ . '/constants/' . $file;
}

return $values;

