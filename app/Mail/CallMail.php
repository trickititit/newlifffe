<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@stargaming.ru', 'Агенство недвижимости "Новая жизнь"')->subject('Звонок')
            ->view('vendor.mail.html.call')->with(['name' => $this->request['name'], 'phone' => $this->request['phone'], 'mail' => $this->request['mail']]);
    }
}
