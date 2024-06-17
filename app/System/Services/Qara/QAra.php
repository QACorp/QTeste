<?php

namespace App\System\Services\Qara;


use OpenAI;
use Spatie\LaravelData\DataCollection;

class QAra
{
    const MODEL = 'gpt-3.5-turbo';
    public function __construct(
        private readonly string $apiKey
    ){}

    public static function factory(string $apiKey):QAra
    {
        return new self($apiKey);
    }
    public function getChat(DataCollection $messages){

        $client = OpenAI::client($this->apiKey);
        return $client->chat()->create([
            'response_format' => ["type" => "json_object" ],
            'model' => self::MODEL,
            'messages' => $messages->toArray()
        ]);
    }
}
