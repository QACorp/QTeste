<?php

namespace App\System\Services\Mail\DTOs;

use App\System\Utils\DTO;

class MailDTO extends DTO
{
    public string $mailMailer;
    public string $mailHost;
    public string $mailPort;
    public string $mailUsername;
    public string $mailPassword;
    public string $mailEncryption;
    public string $mailFromAddress;
    public string $mailFromName;
}
