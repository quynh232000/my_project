<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

trait RouteHelper
{
    public static function getRouteSettings($prefixes = [])
    {
        $allRoutes = collect(Route::getRoutes())
            ->map(function ($route) {
                $uri  = $route->uri();
                $routeName = $route->getName() ?: str_replace('/', '.', $uri);

                // Sinh title dễ đọc từ route_name
                $parts = explode('.', $routeName);
                $readable = collect(array_slice($parts, 2)) // bỏ api, v1
                    ->map(fn($word) => ucfirst($word))
                    ->implode(' ');

                return [
                    'name'       => $readable,                    // Cms Auth Register
                    'uri'        => $uri,                         // api/v1/cms/auth/register
                    'method'     => implode('|', $route->methods()),
                    'route_name' => $routeName,                   // api.v1.cms.auth.register
                ];
            })
            ->filter(function ($r) use ($prefixes) {
                if (empty($prefixes)) {
                    return !str_starts_with($r['uri'], '_')
                        && !str_contains($r['uri'], 'telescope');
                }

                return !str_starts_with($r['uri'], '_')
                    && !str_contains($r['uri'], 'telescope')
                    && collect($prefixes)->contains(fn($prefix) => str_starts_with($r['uri'], $prefix));
            });

        return $allRoutes;
    }
}
