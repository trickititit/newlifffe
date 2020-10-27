<?php

namespace App\Repositories;

use App\User;
use App\Repositories\PolicesRepository;
use Config;
use Photo;
use Gate;
use Illuminate\Support\Facades\Auth;


class UsersRepository extends Repository
{

    protected $p_rep;
    protected $user;

	public function __construct(User $user, PolicesRepository $p_rep) {
		$this->model  = $user;
		$this->p_rep = $p_rep;
	}
	
	public function addUser($request) {
        $this->user = Auth::user();
        $image = $request->file('image');
		$data = $request->all();
		$this->model->name = $data['name'];
		$this->model->telefon = $data['telefon'];
		$this->model->login = $data['login'];
		$this->model->email = $data['email'];
		$this->model->password = bcrypt($data['password']);
        if ($this->user->can('editPolice',$this->user) && isset($data['role'])) {
            $this->model->role_id = $data['role'];
        } else {
            $this->model->role_id = 2;
        }
		if($this->model->save()) {
            if ($this->user->can('editPolice',$this->user) && isset($data["polices"])) {
                $this->model->polices()->attach($data["polices"]);
            }
            if ($request->hasFile('image')) {
                if ($image->isValid()) {
                    $storeFolder = public_path() . '/' . config('settings.theme') . '/uploads/avatar/';   //2
                    $img = Photo::make($image);
                    $img_type = $this->getTypeImg($img->mime());
                    if($img_type == ".err") {
                        return ['status' => 'Пользователь добавлен без аватара'];
                    }
                    $id = $this->model->id;
                    $img->fit(256, 256)->save($storeFolder . "avatar-". $id . "-256". $img_type);
                    $img->fit(128, 128)->save($storeFolder . "avatar-". $id . "-128". $img_type);
                    $img->fit(64, 64)->save($storeFolder . "avatar-". $id . "-64". $img_type);
                    $img->fit(48, 48)->save($storeFolder . "avatar-". $id . "-48". $img_type);
                    $img->fit(32, 32)->save($storeFolder . "avatar-". $id . "-32". $img_type);
                    $this->model->image = $img_type;
                    $this->model->update();
                }
                return ['status' => 'Пользователь добавлен'];
            } else {
                return ['status' => 'Пользователь добавлен'];
            }
        }
	}
	
	
	public function updateUser($request, $user) {
        $this->user = Auth::user();
		$data = $request->all();
        $image = $request->file('image');
        $user->name = $data['name'];
        $user->telefon = $data['telefon'];
        $user->login = $data['login'];
        $user->email = $data['email'];
        //@TODO:Чтото с правами
        if ($this->user->can('editPolice',$this->user) && isset($data['role'])) {
            $user->role_id = $data['role'];
        } else {
            $user->role_id = 3;
        }
        if ($this->user->can('editPolice', $this->user) && isset($data["polices"])) {
            $user->polices()->sync(array_values($data["polices"]));
        } elseif ($this->user->can('editPolice', $this->user) && !isset($data["polices"]))  {
            $user->polices()->detach();
        }
        if(isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }
        if ($request->hasFile('image')) {
            if ($image->isValid()) {
                $storeFolder = public_path() . '/' . config('settings.theme') . '/uploads/avatar/';   //2
                $img = Photo::make($image);
                $img_type = $this->getTypeImg($img->mime());
                if($img_type == ".err") {
                    return ['status' => 'Не корректная фотография'];
                }
                $id = $user->id;
                $img->fit(256, 256)->save($storeFolder . "avatar-". $id . "-256". $img_type);
                $img->fit(128, 128)->save($storeFolder . "avatar-". $id . "-128". $img_type);
                $img->fit(64, 64)->save($storeFolder . "avatar-". $id . "-64". $img_type);
                $img->fit(48, 48)->save($storeFolder . "avatar-". $id . "-48". $img_type);
                $img->fit(32, 32)->save($storeFolder . "avatar-". $id . "-32". $img_type);
                $user->image = $img_type;
            }
        }
        if($user->update()) {
            return ['status' => 'Пользователь изменен'];
        } else {
            return ['error' => 'Ошибка изменения пользователя'];
        }
	}
	
	public function deleteUser($user) {
        $this->user = Auth::user();
		if ($this->user->cant('delete',$this->user)) {
            return ["error" => "Запрещено"];
        }
		if($user->delete()) {
			return ['status' => 'Пользователь удален'];	
		} else {
			return ["error" => "Ошибка удаления пользователя"];
		}
	}

    private function getTypeImg($mime) {
        if ($mime == "image/gif") {
            return ".gif";
        } else if ($mime == "image/jpeg") {
            return ".jpg";
        } else if ($mime == "image/png") {
            return ".png";
        } else {
            return ".err";
        }

    }

}