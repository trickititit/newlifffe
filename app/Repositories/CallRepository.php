<?php
/**
 * Created by PhpStorm.
 * User: G_Andreev
 * Date: 28.01.2019
 * Time: 13:19
 */

namespace App\Repositories;

use App\Call;


class CallRepository extends Repository {

    public function __construct(Call $call) {
        $this->model = $call;
    }

    public function Add($call) {

        $this->model->create([
            'number' => $call['number'],
            'url' => $call['url'],
            'status' => $call['status'],
            'exec_at' => $call['exec_at'],
            'object_id' => $call['object_id'],
        ]);

        dump("СОздание");
        return true;
    }

}