<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestFromSite extends Mailable
{
    use Queueable, SerializesModels;

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
        return $this->from('info@stargaming.ru', 'Агенство недвижимости "Новая жизнь"')->subject('Заявка')
            ->view('vendor.mail.html.layout')->with(['name' => $this->request['name'], 'text' => $this->request['message'], 'phone' => $this->request['phone'], 'mail' => $this->request['mail']]);
    }
}
