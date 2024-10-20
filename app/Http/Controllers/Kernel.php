<?php
namespace App\Http;


use App\Http\Middleware\AccessMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'role' => AccessMiddleware::class
    ];
}
