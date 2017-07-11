<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\UserValidation;

class ValidationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userValidation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserValidation $userValidation = null)
    {
        $this->userValidation = $userValidation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Link de Autenticação (Gati - Aval)');
        return $this->markdown('email.validationEmail');
    }
}
