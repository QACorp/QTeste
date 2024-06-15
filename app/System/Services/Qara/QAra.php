<?php

namespace App\System\Services\Qara;


use OpenAI\Laravel\Facades\OpenAI;
use Spatie\LaravelData\DataCollection;

class QAra
{
    const MODEL = 'gpt-3.5-turbo';
    public static function getChat(DataCollection $messages){
        return OpenAI::chat()->create([
            'response_format' => ["type" => "json_object" ],
            'model' => self::MODEL,
            'messages' => $messages->toArray()
        ]);
    }
}
