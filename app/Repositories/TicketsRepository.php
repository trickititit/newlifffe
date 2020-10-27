<?php
/**
 * Created by PhpStorm.
 * User: G_Andreev
 * Date: 09.01.2019
 * Time: 11:57
 */

namespace App\Repositories;

use App\Ticket;

class TicketsRepository extends Repository
{

    public function __construct(Ticket $ticket) {
        $this->model = $ticket;
    }

    public function add($request, $user_id) {

        $data = $request->all();
        $this->model->create([
            'title' => $data['title'],
            'text' => $data['text'],
            'user_id' => $user_id,
            'status' => 0
        ]);

        return ['status' => 'Тикет добавлен'];

    }

    public function delete($ticket) {
        if($ticket->delete()) {
            return ['status' => 'Тикет удален'];
        } else {
            return ["error" => "Ошибка удаления тикета"];
        }
    }

}