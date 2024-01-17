<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class emailMudancaRestricoes extends Mailable
{
    use Queueable, SerializesModels;
    
    public $docente;
    public $ano;
    public $anoProximo;
    public $semestre;
    public $ucResp;
    public $link;
    public $appName;
    public $ucsRespList;
    public $dataFim;

    /**
     * Create a new message instance.
     */
    public function __construct($docente,$periodo,$ucResp,$dataFim)
    {
        //
        $this->docente=$docente->nome;
        $this->ano=$periodo->ano;
        $this->anoProximo = is_numeric($periodo->ano) ? (int)$periodo->ano + 1 : null;
        $this->semestre=$periodo->semestre;
        $this->ucResp=$ucResp;
        $this->link=env('APP_URL')."/restricoes";
        $this->appName=env('APP_NAME');
        $this->ucsRespList=$this->ucsRespList();
        $this->dataFim=$dataFim;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Novo Formulário de Restrições Disponivel - SCH - ESTGA - UA',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.emailMudancaRestricoes',
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
    public function ucsRespList(): string
    {

        $list = "<p>&emsp;Foi lhe atribuído a Unidade Curricular, como docente responsável:</p><ul>";
        $list .= "<li>" . $this->ucResp->codigo . " - " . $this->ucResp->nome . "</li>";
        $list .= "</ul><br>";
        return $list;
    }
}
