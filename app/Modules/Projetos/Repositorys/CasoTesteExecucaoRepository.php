<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Business\PlanoTesteExecucaoBusiness;
use App\Modules\Projetos\Contracts\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\PlanoTesteRepositoryContract;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteExecucaoDTO;
use App\Modules\Projetos\Enums\PlanoTesteExecucaoEnum;
use App\Modules\Projetos\Models\PlanoTeste;
use App\Modules\Projetos\Models\PlanoTesteExecucao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\DataCollection;

class CasoTesteExecucaoRepository implements CasoTesteExecucaoRepositoryContract
{


}
