<?php

namespace App\System\Services\Qara;

enum QAraRoleEnum:string
{
    case USER = 'user';
    case PROMPT = 'prompt';
    case ASSISTANT = 'assistant';
    case SYSTEM = 'system';
}
