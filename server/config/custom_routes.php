<?php

// $customRoutesAdmin   = [];

// $routePathAdmin = __DIR__ . '/routes/admin';

// $iteratorAdmin = new RecursiveIteratorIterator(
//     new RecursiveDirectoryIterator($routePathAdmin),
//     RecursiveIteratorIterator::LEAVES_ONLY
// );

// // Lặp qua từng file
// foreach ($iteratorAdmin as $file) {
//     if ($file->isFile() && $file->getExtension() === 'php') {
//         $customRoutesAdmin[] = require $file->getPathname();
//     }
// }


// $routeApiV1Portfolio   = [];

// $pathApiV1Portfolio = __DIR__ . '/routes/admin';

// $iteratorAppiV1Portfolio = new RecursiveIteratorIterator(
//     new RecursiveDirectoryIterator($pathApiV1Portfolio),
//     RecursiveIteratorIterator::LEAVES_ONLY
// );

// // Lặp qua từng file
// foreach ($iteratorAppiV1Portfolio as $file) {
//     if ($file->isFile() && $file->getExtension() === 'php') {
//         $routeApiV1Portfolio[] = require $file->getPathname();
//     }
// }
// return [
//     'web' => $routeApiV1Portfolio,
//     'api' => [
//         'v1' => $routeApiV1Portfolio
//     ]
// ];



/**
 * Đọc toàn bộ file PHP trong thư mục $path và merge
 * các mảng route mà mỗi file trả về.
 *
 * @param  string $path  Đường dẫn tương đối tính từ thư mục hiện tại,
 *                       ví dụ '/routes/admin'
 * @return array         Mảng routes đã gộp
 */
function loadRouteFiles(string $relativePath): array
{
    $allRoutes = [];
    $fullPath  = __DIR__ . $relativePath;

    if (!is_dir($fullPath)) {
        return $allRoutes;            // tránh lỗi khi thư mục chưa tồn tại
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($fullPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $loaded = require $file->getPathname();

            if (is_array($loaded)) {
                // $loaded có thể là một group (mảng 1 chiều) hoặc list group (mảng 2 chiều)
                $allRoutes = array_merge($allRoutes, is_array($loaded[0] ?? null) ? $loaded : [$loaded]);
            } else {
                trigger_error(
                    "Route file {$file->getPathname()} must return array, '".gettype($loaded)."' given",
                    E_USER_WARNING
                );
            }
        }
    }

    return $allRoutes;
}
return [
    'web' => loadRouteFiles('/routes/admin'),               // đúng cho Admin
    'api' => [
        'v1' => loadRouteFiles('/routes/api/v1'), // đúng cho API v1
    ],
];
