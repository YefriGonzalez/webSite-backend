<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $email;
    public $subject;
    public $message;
    public $name;
    public function __construct($email, $subject, $message, $name)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject($this->subject)
            //->html("<span>Codigo: </span> <p>$this->token</p> <span>Si usted no ha solicitado cambiar su contraseña
            //, comuniquese a ine.gob.gt</span>")
            ->html('<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Cambio de  contraseña</title>
            </head>
            <body style="background-color: #f6f6f6;">
                <div style="background-color: #f6f6f6; padding: 40px;">
                    <div style="background-color: #ffffff; max-width: 600px; margin: 0 auto; padding: 40px;">
                        <p> De: ' . $this->email . ' ' . $this->name . ' <p>
                        <p>' . $this->message . ' </p>
                    </div>
                </div>  
            </body>
            </html>
            ')
            ->from($this->email, $this->name)
            ->text('');

    }



}