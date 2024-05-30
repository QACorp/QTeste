<?php

namespace App\Modules\Projetos\Controllers;


use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Spatie\LaravelData\DataCollection;

class ConsultaCasoTesteController extends Controller
{
    use EquipeTools;
    public function __construct(
        private readonly CasoTesteBusinessContract $casoTesteBusiness
    )
    {
    }

    public function getCasosTeste(Request $request){
        $term = $request->get('term');
        if ($term){
            $casosTeste = $this->casoTesteBusiness->buscarCasoTestePorString($term,EquipeUtils::equipeUsuarioLogado());
            return response()->json($casosTeste);
        }
    }

    public function getCasosTestePorId(int $idCasoTeste){

        $casosTeste = $this->casoTesteBusiness->buscarCasoTestePorId($idCasoTeste,EquipeUtils::equipeUsuarioLogado());
        return response()->json($casosTeste);
    }


}
