<?php

namespace App\Modules\GestaoEquipe\Submodules\Checkpoint\Controllers;

use App\System\Http\Controllers\Controller;

class CheckpointController extends Controller
{
    public function index()
    {
        return view('checkpoint::index');
    }

}
