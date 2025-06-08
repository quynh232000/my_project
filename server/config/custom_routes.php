<?php

$customRoutesAdmin   = [];

$routePathAdmin = __DIR__ . '/routes/admin';

$iteratorAdmin = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($routePathAdmin),
    RecursiveIteratorIterator::LEAVES_ONLY
);

// Lặp qua từng file
foreach ($iteratorAdmin as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $customRoutesAdmin[] = require $file->getPathname();
    }
}
return [
    'web' => $customRoutesAdmin
];
