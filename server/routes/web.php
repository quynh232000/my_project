<?php

use Illuminate\Support\Facades\Route;

Route::get('/',function(){
    return config('constants.table.general');
});

