<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $full_name;
    public $code;

    public function __construct($full_name, $code)
    {
        // Log incoming values
        \Log::info('Constructing SendCodeMail.', [
            'full_name' => $full_name,
            'code' => $code
        ]);

        $this->full_name = $full_name;
        $this->code = $code;
    }

    public function build()
    {
        // Log before sending the view
        \Log::info('Building email with data.', [
            'full_name' => $this->full_name,
            'code' => $this->code
        ]);

        // passing the variables to the view
        return $this->view('emails.test')
                    ->with([
                        'full_name' => $this->full_name,
                        'code' => $this->code
                    ]);
    }
}
