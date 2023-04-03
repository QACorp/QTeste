<?php
namespace App\Modules\Example\Controller;

use App\System\Http\Controllers\Controller;
use App\System\Http\Middleware\Authenticate;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

class ExampleController extends Controller
{
    public function myMethod() {
        dd(auth()->user());
        return view('teste');
    }
}
