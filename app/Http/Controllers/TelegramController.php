<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UsersRepository;
use App\Repositories\ObjectsRepository;

class TelegramController extends Controller
{
    private $_token = "416199487:AAEA4QkFjveTQZBer8BkmC_3YbWF76NTOLM";
    private $_u_rep;
    private $_o_rep;

    public function __construct(UsersRepository $u_rep, ObjectsRepository $o_rep)
    {
        $this->_u_rep = $u_rep;
        $this->_o_rep = $o_rep;
    }

    public function sendMessage(Request $request) {
        $user_id = $request->user_id;
        $object = $this->_o_rep->get("*", false, false, ["id", $request->obj_id])[0];
        $message = "Меня зовут: " . $request->name . "\r\nМой телефон: " . $request->phone . "\r\nМой email: " . $request->mail . "\r\nЯ по поводу объекта " . $this->_o_rep->getTitle($object) . " находящегося по адресу " . $object->address . ".\r\n" .$request->message;
        $user = $this->_u_rep->get("*", false, false, ["id", $user_id])[0];
        $parameters = [
          "chat_id" => $user->telegram_id,
          "text" => $message,
        ];

        $url = "https://api.telegram.org/bot$this->_token/sendMessage?".http_build_query($parameters);
        file_get_contents($url);
        return 'ok';
    }

}
