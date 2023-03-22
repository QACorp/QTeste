<?php
namespace App\Modules\Example\Controller;

use App\System\Http\Controllers\Controller;
use Spatie\RouteAttributes\Attributes\Get;

class ExampleController extends Controller
{
    #[Get('teste')]
    public function myMethod() {
        return view('teste');
    }
}
