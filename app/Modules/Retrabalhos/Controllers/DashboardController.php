<?php

namespace App\Modules\Retrabalhos\Controllers;

use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $anos = range(2023, date('Y'));
        return view('retrabalhos::dashboard.index', [
            'ano' => $request->get('ano', date('Y')),
            'anos' => $anos
        ]);
    }
}
