<?php

namespace App\System\Services\Qara\DTOs;

use App\System\Services\Qara\QAraRoleEnum;
use App\System\Utils\DTO;

class QAraMessageDTO extends DTO
{
    public QAraRoleEnum $role;
    public string $content;
}
