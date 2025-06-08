<?php

namespace App\Http\Controllers;
use App\Traits\ApiResponse;
/**
 * @OA\Info(
 *      title="API Quin Ecommerce",
 *      version="1.0.0"
 * ),
 */
abstract class ApiController extends Controller
{
    use ApiResponse;
}
