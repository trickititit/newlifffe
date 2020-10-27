<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SettingsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends AdminController
{

    protected $s_rep;

    public function __construct(SettingsRepository $s_rep) {
       parent::__construct(new \App\Repositories\AdmMenusRepository(new \App\AdmMenu), new \App\Repositories\SettingsRepository(new \App\Setting()), new \App\Repositories\AobjectsRepository(new \App\Aobject()), new \App\User);
//        if(Gate::denies('VIEW_ADMIN')) {
//            abort(403);
//        }
        $this->s_rep = $s_rep;
        $this->template = config('settings.theme').'.admin.index';
    }
    
    
    public function edit() {
        $this->checkUser();
        $this->content = view(config('settings.theme').'.admin.settings')->with(array("settings" => $this->settings))->render();
        $this->title = "Настройки";
        return $this->renderOutput();
    }
    
    public function update(Request $request) {
        $result = $this->s_rep->updateSettings($request);
        return redirect("/admin")->with($result);
    }
}
