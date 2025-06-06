<?php

use App\Http\Controllers\Api\Public\CollectionPageController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [CollectionPageController::class, 'get_all_products']);
