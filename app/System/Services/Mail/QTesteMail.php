<?php

namespace App\System\Services\Mail;

use App\System\Services\Mail\DTOs\MailDTO;
use Illuminate\Support\Facades\Config;

class QTesteMail
{
    public static function configure(MailDTO $mailDTO): void
    {

        $config = array(
            'driver'     => $mailDTO->mailMailer,
            'host'       => $mailDTO->mailHost,
            'port'       => $mailDTO->mailPort,
            'from'       => array('address' => $mailDTO->mailFromAddress, 'name' => $mailDTO->mailFromName),
            'encryption' => $mailDTO->mailEncryption,
            'username'   => $mailDTO->mailUsername,
            'password'   => $mailDTO->mailPassword
        );

        Config::set('mail', $config);

    }
}
