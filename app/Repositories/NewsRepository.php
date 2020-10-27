<?php
/**
 * Created by PhpStorm.
 * User: Трик
 * Date: 11.07.2017
 * Time: 19:39
 */

namespace App\Repositories;

use App\Anew;

class NewsRepository extends Repository
{

    public function __construct(Anew $new) {
        $this->model = $new;
    }


    public function addNew($request) {
//		if (\Gate::denies('create',$this->model)) {
////            abort(403);
//        }
        $data = $request->all();
        $this->model->create([
            'title' => $data['title'],
            'text' => $data['text']
        ]);

        return ['status' => 'Новость добавлена'];

    }

    public function deleteNew($new) {
        if($new->delete()) {
            return ['status' => 'Новость удалена'];
        } else {
            return ["error" => "Ошибка удаления новости"];
        }
    }
}