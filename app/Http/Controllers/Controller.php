<?php

namespace App\Http\Controllers;

use App\Http\Contracts\ResponseTrait;

/**
 * @OA\Info(
 *     title="GSM Pay",
 *     version="1.0.0",
 *     description="API documentation"
 * )
 */
abstract class Controller
{
    use ResponseTrait;
}

