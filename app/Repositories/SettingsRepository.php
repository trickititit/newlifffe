<?php

namespace App\Repositories;

use App\Setting;
use Gate;

class SettingsRepository extends Repository {

    public function __construct(Setting $setting) {
        $this->model = $setting;
    }

    public function updateSettings($request) {
        $data = $request->except('_token', '_method');;
        foreach ($data as $key => $value) {
            $setting = $this->model->whereName($key)->first();
            $setting->param = $value;
            if (!$setting->update()) {
                return array("error" => "Ошибка обновления настроек");
            }
        }

        return array("status" => "Настройки обновлены");
    }
}

?>