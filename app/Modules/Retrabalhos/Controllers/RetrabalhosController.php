<?php

namespace App\Modules\Retrabalhos\Controllers;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDTO;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Spatie\LaravelData\DataCollection;


class RetrabalhosController extends Controller
{
    use EquipeTools;
    public function __construct(
        private readonly RetrabalhoBusinessContract $retrabalhoBusiness
    )
    {

    }
    public function index()
    {
        return view('retrabalhos::index');
    }

    public function inserir()
    {
        return view('retrabalhos::inserir');
    }

    public function salvar(RetrabalhoDTO $retrabalhoDTO)
    {
        //dd($retrabalhoDTO);
        return view('retrabalhos::inserir');
    }

}
