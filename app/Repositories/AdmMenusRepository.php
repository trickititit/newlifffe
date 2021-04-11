<?php

namespace App\Repositories;

use Gate;
use App\AdmMenu;
use Illuminate\Support\Facades\Auth;

class AdmMenusRepository extends Repository
{
    public function __construct(AdmMenu $menu)
    {
        $this->model = $menu;
    }

    public function getMenu($type)
    {
        $user = Auth::user();
        return $user->role->menus()->whereType($type)->get();
    }
}
