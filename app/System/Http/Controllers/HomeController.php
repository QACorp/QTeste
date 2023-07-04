<?php

namespace App\System\Http\Controllers;

use App\System\Config\DashboardConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        if(!EquipeUtils::equipeUsuarioLogado()){
            Cookie::queue(config('app.cookie_equipe_nome'), Auth::user()->equipes()->first()->id, (60*60*60));
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
