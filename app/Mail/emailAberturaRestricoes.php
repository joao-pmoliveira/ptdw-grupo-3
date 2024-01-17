<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class emailAberturaRestricoes extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $docente;
    public $ano;
    public $anoProximo;
    public $semestre;
    public $ucs;
    public $ucsResp;
    public $withUcs;
    public $link;
    public $appName;
    public $ucsList;
    public $ucsRespList;
    public function __construct($docente,$periodo,$ucsResp,$ucs,$dataFim)
    {
        //
        $this->docente=$docente->nome;
        $this->ano=$periodo->ano;
        $this->anoProximo = is_numeric($periodo->ano) ? (int)$periodo->ano + 1 : null;
        $this->semestre=$periodo->semestre;
        $this->ucs=$ucs;
        $this->ucsResp=$ucsResp;
        $this->withUcs = $ucs ? " e os formulários de Restrições de Unidades Curriculares" : "";
        $this->link=env('APP_URL')."/restricoes";
        $this->appName=env('APP_NAME');
        $this->ucsList=$this->ucsList();
        $this->ucsRespList=$this->ucsRespList();
        $this->dataFim=$dataFim;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Formulário de Restrições Disponivel - SCH - ESTGA - UA',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.emailAberturaRestricoes',
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
        $list = "";
        $ucsResp2=collect();
        foreach($this->ucsResp as $uc){
            if($uc->periodo->ano==$this->ano && $uc->periodo->semestre==$this->semestre){
                $ucsResp2->add($uc);
            }
        }
        if ($ucsResp2->isNotEmpty()) {
            $list .= "<p>&emsp;Foi lhe atribuído as Unidades Curriculares, como docente responsável:</p><ul>";
            foreach ($ucsResp2 as $uc) {
                $list .= "<li>" . $uc->codigo . " - " . $uc->nome . "</li>";
            }
            $list .= "</ul><br>";
        }

        return $list;
    }
    public function ucsList(): string
    {
        $list = "";
        $ucsResp2=collect();
        foreach($this->ucsResp as $uc){
            if($uc->periodo->ano==$this->ano && $uc->periodo->semestre==$this->semestre){
                $ucsResp2->add($uc);
            }
        }
        $ucs2=collect();
        foreach($this->ucs as $uc){
            if($uc->periodo->ano==$this->ano && $uc->periodo->semestre==$this->semestre){
                $ucs2->add($uc);
            }
        }
        if ($ucs2->isNotEmpty()) {
            if ($ucsResp2->isNotEmpty()) {
                $list .= "<p>&emsp;E como docente auxiliar:</p><ul>";
            } else {
                $list .= "<p>&emsp;Foi lhe atribuído as Unidades Curriculares, como docente auxiliar:</p><ul>";
            }
            foreach ($ucs2 as $uc) {
                $list .= "<li>" . $uc->codigo . " - " . $uc->nome . "</li>";
            }
            $list .= "</ul><br>";
        }

        return $list;
    }
}
