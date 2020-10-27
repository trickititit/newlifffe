<?php

namespace App\Http\Controllers;

use App\Mail\CallMail;
use Illuminate\Http\Request;
use App\Mail\RequestFromSite;
use Illuminate\Support\Facades\Mail;

class MailController extends SiteController
{
    //
    public function sendRequest(Request $request) {
        $data = $request->all();
        Mail::to($this->settings['mail'])->send(new RequestFromSite($data));
        return 'ok';
    }

    public function sendCall(Request $request) {
        $data = $request->all();
        Mail::to($this->settings['mail'])->send(new CallMail($data));
        return 'ok';
    }
}
