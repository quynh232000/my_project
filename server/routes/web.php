<?php

use Illuminate\Support\Facades\Route;

$groups = config('custom_routes.web');

foreach ($groups as $group) {
    Route::prefix($group['prefix'] ?? '')
        ->middleware($group['middleware'] ?? [])
        ->group(function () use ($group) {
            foreach ($group['routes'] as $route) {
                switch (($route['type'] ?? '')) {
                    case 'resource':
                        $resourceOptions = [];

                        if (!empty($route['only'])) {
                            $resourceOptions['only'] = $route['only'];
                        }

                        if (!empty($route['except'])) {
                            $resourceOptions['except'] = $route['except'];
                        }

                        Route::resource($route['uri'], $route['controller'], $resourceOptions)->names(
                            collect($route['only'] ?? [
                                'index',
                                'create',
                                'store',
                                'show',
                                'edit',
                                'update',
                                'destroy'
                            ])->mapWithKeys(function ($method) use ($route) {

                                $prefix         = $route['name_prefix'] ?? $route['uri'];
                                return [$method => $prefix . "." . $method];
                            })->toArray()
                        );

                        // Optionally xử lý labels
                        foreach ($route['labels'] ?? [] as $method => $label) {
                            // Sync permission logic nếu cần
                        }
                        break;

                    default:
                        $methods    = $route['methods'] ?? [];
                        $action     = [$route['controller'] ?? 'admin', $route['action'] ?? 'index'];
                        $routeObj   = in_array('any', $methods)
                            ? Route::any($route['uri'], $action)
                            : Route::match($methods, $route['uri'], $action);

                        if (!empty($route['name'])) {
                            $routeObj->name($route['name']);
                        }
                        break;
                }
            }
        });
}


// hotel
//Hotel
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'attribute.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'bank.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'chain.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'customer.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'hotel.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'policy-setting.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'room-type.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'service.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'review.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'partner-register.php');
require_once(PATH_ROUTE . DS . 'hotel' . DS . 'payment-info.php');



Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
