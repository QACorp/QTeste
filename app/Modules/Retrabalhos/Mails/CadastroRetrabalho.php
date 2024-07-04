<?php

namespace App\Modules\Retrabalhos\Mails;

use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDTO;
use App\System\Services\Mail\DTOs\MailDTO;
use App\System\Services\Mail\QTesteMail;
use App\System\Traits\Configuracao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class CadastroRetrabalho extends Mailable
{
    use Queueable, SerializesModels, Configuracao;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            subject: 'Novo retrabalho',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'retrabalhos::email.novo-retrabalho',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
