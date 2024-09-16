<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Controllers;

use App\System\Http\Controllers\Controller;

class CheckpointController extends Controller
{
    public function index()
    {
        return view('checkpoint::index');
    }

}
