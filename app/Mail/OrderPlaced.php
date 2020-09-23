<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;
    protected $email_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->email_data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email_data = $this->email_data;
        return $this->view('mail.OrderPlaced')
            ->subject($email_data['subject'])
            
            ->with([
                'email_data' => $email_data
            ]);
        // return $this->view('view.name');
    }
}
