<?php

namespace App\Modules\GestaoEquipe\Observacao\Controllers\API;

use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\DTOs\CheckpointDTO;
use App\Modules\GestaoEquipe\Observacao\Contracts\Business\ObservacaoBusinessContract;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\RequestGuardTraits;
use App\System\Utils\EquipeUtils;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ObservacaoController extends Controller
{
    use RequestGuardTraits;
    public function __construct(
        private readonly ObservacaoBusinessContract $observacaoBusiness,

    )
    {
    }

}
