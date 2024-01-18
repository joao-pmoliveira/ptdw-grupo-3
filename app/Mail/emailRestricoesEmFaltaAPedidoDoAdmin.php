<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class emailRestricoesEmFaltaAPedidoDoAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $docente;
    public $ano;
    public $anoProximo;
    public $semestre;
    public $ucsResp;
    public $link;
    public $appName;
    public $ucsRespList;
    public $dataFim;
    public $formType;
    /**
     * Create a new message instance.
     */
    public function __construct($docente,$periodo,$ucsResp,$dataFim,$horaEmFalta)
    {
        //
        $this->docente=$docente->nome;
        $this->ano=$periodo->ano;
        $this->anoProximo = is_numeric($periodo->ano) ? (int)$periodo->ano + 1 : null;
        $this->semestre=$periodo->semestre;
        $this->ucsResp=$ucsResp->where('restricoes_submetidas',False);
        $this->formType=$this->formType($horaEmFalta,$ucsResp);
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
            subject: 'Email Restricoes Em Falta A Pedido Do Admin',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
    public function formType($horaEmFalta,$ucsResp): string
    {
        $text = "";
        if($horaEmFalta==true){
            $text.=" de Impedimentos de Horários";
            if($ucsResp->isNotEmpty()){
                $text.=" e os formulários de Restrições de Unidades Curriculares";
            }
        }
        else{
            $text.=" de Restrições de Unidades Curriculares";
        }
        return $text;
    }
    public function ucsRespList(): string
    {
        $list = "";
        if ($this->ucsResp->isNotEmpty()) {
            $list .= "<p>&emsp;Tem em falta o preenchimento das restrições das Unidades Curriculares, em que é docente responsável:</p><ul>";
            foreach ($this->ucsResp as $uc) {
                $list .= "<li>" . $uc->codigo . " - " . $uc->nome . "</li>";
            }
            $list .= "</ul><br>";
        }

        return $list;
    }
}
